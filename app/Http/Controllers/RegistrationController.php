<?php

namespace App\Http\Controllers;

use App\Mail\NewRegistrationAlertMail;
use App\Mail\RegistrationReceivedMail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function show()
    {
        return view('landing.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'market_name' => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'owner_phone' => 'nullable|string|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $tenant = DB::transaction(function () use ($data) {
            $tenant = Tenant::create([
                'name' => $data['market_name'],
                'sector' => $data['sector'] ?? null,
                'status' => 'pending',
                'owner_name' => $data['owner_name'],
                'owner_email' => $data['owner_email'],
                'owner_phone' => $data['owner_phone'] ?? null,
                'subscribed_at' => now(),
            ]);

            User::create([
                'tenant_id' => $tenant->id,
                'name' => $data['owner_name'],
                'email' => strtolower($data['owner_email']),
                'password' => $data['password'],
                'role' => 'admin',
                'status' => 'active',
            ]);

            return $tenant;
        });

        $this->notifyRegistration($tenant, $data);

        return redirect()
            ->route('landing.register.show')
            ->with('success', "Votre espace a bien été créé et est en cours de validation. Nous revenons vers vous rapidement pour l'activer — vous pourrez alors vous connecter normalement.");
    }

    private function notifyRegistration(Tenant $tenant, array $data): void
    {
        try {
            Mail::to($data['owner_email'])->send(
                new RegistrationReceivedMail($data['market_name'], $data['owner_name'])
            );
        } catch (\Throwable $e) {
            report($e);
        }

        $superAdminEmails = User::withoutGlobalScope('tenant')
            ->where('role', 'super_admin')
            ->pluck('email');

        foreach ($superAdminEmails as $email) {
            try {
                Mail::to($email)->send(new NewRegistrationAlertMail($tenant));
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }
}