<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /** Où rediriger chaque rôle après connexion */
    private function redirectRouteFor(string $role): string
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'manager' => 'manager.dashboard',
            'cashier' => 'cashier.dashboard',
            default => 'login',
        };
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

        $user = User::where('email', $email)->first();

        // Email inconnu
        if (!$user) {
            $this->registerFailedAttempt($email);
            ActivityLog::recordFailedLogin($email);
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Aucun compte trouvé avec cet email.');
        }

        // Compte désactivé par un admin
        if ($user->status !== 'active') {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Ce compte est désactivé. Contactez un administrateur.');
        }

        // Mot de passe incorrect
        if (!Hash::check($request->password, $user->password)) {
            $locked = $this->registerFailedAttempt($email);
            ActivityLog::recordFailedLogin($email);
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

        // Succès password → PAS de connexion encore : envoi OTP
        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            'login_otp'          => $otp,
            'login_otp_email'    => $email,
            'login_otp_role'     => $user->role,
            'login_otp_redirect' => $this->redirectRouteFor($user->role),
            'login_otp_expires'  => now()->addMinutes(10)->timestamp,
        ]);

        $real = filter_var(env('MAIL_OTP_REAL', false), FILTER_VALIDATE_BOOLEAN);

        if ($real) {
            try {
                Mail::to($email)->send(new OtpMail($otp, $email));
            } catch (\Throwable $e) {
                return back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Impossible d\'envoyer le code OTP. ' . $e->getMessage());
            }

            return redirect()
                ->route('login.otp')
                ->with('success', 'Un code a été envoyé à votre adresse email.');
        }

        // Mode démo seulement si MAIL_OTP_REAL=false
        return redirect()
            ->route('login.otp')
            ->with('success', 'Code généré (mode démo).')
            ->with('dev_otp', $otp);
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
            $locks[$email] = time() + (15 * 60);
            session(['login_locks' => $locks]);
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
        $user = User::where('email', $email)->first();

        if (!$user) {
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

        if (filter_var(env('MAIL_OTP_REAL', false), FILTER_VALIDATE_BOOLEAN)) {
            try {
                Mail::to($email)->send(new OtpMail($otp, $email));
            } catch (\Throwable $e) {
                report($e);
                return back()->with('error', 'Erreur mail : ' . $e->getMessage());
            }

            return redirect()
                ->route('password.otp')
                ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
        }

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
            'otp_code' => null,
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

        $user = User::where('email', session('otp_email'))->first();

        if (!$user) {
            session()->forget(['otp_email', 'otp_code', 'otp_expires', 'otp_verified']);
            return redirect()->route('password.request')
                ->with('error', 'Utilisateur introuvable.');
        }

        $user->password = $request->password;
        $user->save();

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

    public function showLoginOtp()
    {
        if (!session('login_otp_email')) {
            return redirect()->route('login')
                ->with('error', 'Session expirée. Reconnectez-vous.');
        }

        return view('marketsmart.verify-login-otp', [
            'email' => session('login_otp_email'),
        ]);
    }

    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        if (!session('login_otp_email') || !session('login_otp')) {
            return redirect()->route('login')
                ->with('error', 'Session expirée. Reconnectez-vous.');
        }

        if (session('login_otp_expires') < now()->timestamp) {
            session()->forget([
                'login_otp', 'login_otp_email', 'login_otp_role',
                'login_otp_redirect', 'login_otp_expires',
            ]);
            return redirect()->route('login')
                ->with('error', 'Code expiré. Reconnectez-vous.');
        }

        if ($request->otp !== session('login_otp')) {
            return back()->with('error', 'Code incorrect.');
        }

        $email    = session('login_otp_email');
        $role     = session('login_otp_role');
        $redirect = session('login_otp_redirect');

        session()->forget([
            'login_otp', 'login_otp_email', 'login_otp_role',
            'login_otp_redirect', 'login_otp_expires', 'dev_otp',
        ]);

        session([
            'auth_user' => $email,
            'auth_role' => $role,
        ]);

        ActivityLog::record('login', 'User Login', ucfirst($role) . ' login', 'LOGIN-' . strtoupper(uniqid()));

        return redirect()->route($redirect)
            ->with('success', 'Connexion réussie.');
    }

    public function resendLoginOtp()
    {
        $email = session('login_otp_email');
        if (!$email) {
            return redirect()->route('login');
        }

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            'login_otp'         => $otp,
            'login_otp_expires' => now()->addMinutes(10)->timestamp,
        ]);

        $real = filter_var(env('MAIL_OTP_REAL', false), FILTER_VALIDATE_BOOLEAN);

        if ($real) {
            try {
                Mail::to($email)->send(new OtpMail($otp, $email));
            } catch (\Throwable $e) {
                return back()->with('error', 'Impossible d\'envoyer le code.');
            }
            return back()->with('success', 'Nouveau code envoyé.');
        }

        return back()
            ->with('success', 'Nouveau code généré.')
            ->with('dev_otp', $otp);
    }
}