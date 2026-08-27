<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
 use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;



class AuthController extends Controller
{
    /** Comptes fictifs (à remplacer par User::where...) */
    private function users(): array
    {
        return [
            'admin@marketsmart.com' => [
                'password' => 'admin123',
                'role' => 'admin',
                'redirect' => 'admin.dashboard',
            ],
                'kuekamjeams@gmail.com' => [
                'password' => 'tonmotdepasse',  // mot de passe pour te connecter au login
                'role' => 'manager',
                'redirect' => 'manager.dashboard',
            ],
            'manager@marketsmart.com' => [
                'password' => 'manager123',
                'role' => 'manager',
                'redirect' => 'manager.dashboard',
            ],
            'cashier@marketsmart.com' => [
                'password' => 'cashier123',
                'role' => 'cashier',
                'redirect' => 'cashier.payment', // adapte si ta route cashier d’accueil est différente
            ],
        ];
    }

    public function showLogin()
    {
        return view('marketsmart.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);
    $email = strtolower(trim($request->email));
    $users = $this->users();
    // --- Compte verrouillé ? ---
    $locks = session('login_locks', []);
    if (isset($locks[$email]) && $locks[$email] > time()) {
        $minutes = (int) ceil(($locks[$email] - time()) / 60);
        return back()
            ->withInput($request->only('email'))
            ->with('error', "Trop de tentatives. Réessayez dans {$minutes} minute(s).");
    }
    // Verrou expiré → nettoyer
    if (isset($locks[$email]) && $locks[$email] <= time()) {
        unset($locks[$email]);
        session(['login_locks' => $locks]);
        $attempts = session('login_attempts', []);
        unset($attempts[$email]);
        session(['login_attempts' => $attempts]);
    }
    // Email inconnu
    if (!isset($users[$email])) {
        $this->registerFailedAttempt($email);
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Aucun compte trouvé avec cet email.');
    }
    // Mot de passe incorrect
    if ($users[$email]['password'] !== $request->password) {
        $locked = $this->registerFailedAttempt($email);
        if ($locked) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Trop de tentatives. Compte verrouillé 15 minutes.');
        }
        $left = 5 - (session('login_attempts')[$email] ?? 0);
        return back()
            ->withInput($request->only('email'))
            ->with('error', "Mot de passe incorrect. Il vous reste {$left} tentative(s).");
    }
    // Succès → reset compteurs
    $attempts = session('login_attempts', []);
    unset($attempts[$email]);
    session(['login_attempts' => $attempts]);
    $locks = session('login_locks', []);
    unset($locks[$email]);
    session(['login_locks' => $locks]);
    session([
        'auth_user' => $email,
        'auth_role' => $users[$email]['role'],
    ]);
    return redirect()
        ->route($users[$email]['redirect'])
        ->with('success', 'Connexion réussie.');
}
/**
* Enregistre un échec. Retourne true si le compte vient d'être verrouillé.
*/
private function registerFailedAttempt(string $email): bool
{
    $attempts = session('login_attempts', []);
    $attempts[$email] = ($attempts[$email] ?? 0) + 1;
    session(['login_attempts' => $attempts]);
    if ($attempts[$email] >= 5) {
        $locks = session('login_locks', []);
        $locks[$email] = time() + (15 * 60); // 15 minutes
        session(['login_locks' => $locks]);
        // reset compteur après lock
        $attempts[$email] = 0;
        session(['login_attempts' => $attempts]);
        return true;
    }
    return false;
}
    public function showForgot()
    {
        return view('marketsmart.forgotpassword');
    }
public function sendOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $email = strtolower(trim($request->email));
    $users = $this->users();

    if (!isset($users[$email])) {
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Aucun compte trouvé avec cet email.');
    }

    $otp = (string) random_int(100000, 999999);

    session([
        'otp_email' => $email,
        'otp_code' => $otp,
        'otp_expires' => now()->addMinutes(10)->timestamp,
        'otp_verified' => false,
    ]);

    // MODE RÉEL : envoi email
    if (filter_var(env('MAIL_OTP_REAL', false), FILTER_VALIDATE_BOOLEAN)) {
        try {
            \Illuminate\Support\Facades\Mail::to($email)->send(
                new \App\Mail\OtpMail($otp, $email)
            );
        } catch (\Throwable $e) {
            report($e);
            return back()->with('error', 'Erreur mail : ' . $e->getMessage());
        }

        return redirect()
            ->route('password.otp')
            ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
    }

    // MODE DÉMO : code à l'écran
    return redirect()
        ->route('password.otp')
        ->with('success', 'Code de vérification généré (mode démo).')
        ->with('dev_otp', $otp);
}
    public function showOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request')
                ->with('error', 'Session expirée. Recommencez.');
        }

        return view('marketsmart.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        if (!session('otp_email') || !session('otp_code')) {
            return redirect()->route('password.request')
                ->with('error', 'Session expirée. Recommencez.');
        }

        if (now()->timestamp > (int) session('otp_expires')) {
            session()->forget(['otp_email', 'otp_code', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')
                ->with('error', 'Code expiré. Demandez-en un nouveau.');
        }

        if ($request->otp !== session('otp_code')) {
            return back()->with('error', 'Code incorrect.');
        }

        session([
            'otp_verified' => true,
            'otp_code' => null, // usage unique
        ]);

        return redirect()->route('password.reset')
            ->with('success', 'Code validé. Définissez votre nouveau mot de passe.');
    }

    public function showReset()
    {
        if (!session('otp_email') || !session('otp_verified')) {
            return redirect()->route('password.request')
                ->with('error', 'Vérification OTP requise.');
        }

        return view('marketsmart.resetting');
    }

    public function resetPassword(Request $request)
    {
        if (!session('otp_email') || !session('otp_verified')) {
            return redirect()->route('password.request')
                ->with('error', 'Vérification OTP requise.');
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // MOCK : en prod → User::where('email', ...)->update(['password' => Hash::make(...)])
        // Ici on simule seulement le succès
        session()->forget(['otp_email', 'otp_code', 'otp_expires', 'otp_verified']);

        return redirect()->route('login')
            ->with('success', 'Mot de passe réinitialisé. Vous pouvez vous connecter.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['auth_user', 'auth_role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}