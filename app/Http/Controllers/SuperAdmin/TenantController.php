<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Mail\AccountActivatedMail;
use App\Mail\WelcomeAdminMail;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TenantController extends Controller
{
    public function create()
    {
        return view('super-admin.tenants.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sector' => 'nullable|string|max:255',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|max:255',
            'owner_phone' => 'nullable|string|max:50',
            'admin_password' => 'required|string|min:6',
        ]);

        DB::transaction(function () use ($data) {
            $tenant = Tenant::create([
                'name' => $data['name'],
                'sector' => $data['sector'] ?? null,
                'status' => 'active',
                'owner_name' => $data['owner_name'],
                'owner_email' => $data['owner_email'],
                'owner_phone' => $data['owner_phone'] ?? null,
                'subscribed_at' => now(),
            ]);

            User::create([
                'tenant_id' => $tenant->id,
                'name' => $data['owner_name'],
                'email' => $data['owner_email'],
                'password' => $data['admin_password'],
                'role' => 'admin',
                'status' => 'active',
            ]);
        });

        try {
            Mail::to($data['owner_email'])->send(
                new WelcomeAdminMail($data['name'], $data['owner_name'], $data['owner_email'], $data['admin_password'])
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()
            ->route('super-admin.dashboard')
            ->with('success', 'Supermarché créé avec succès. Le compte administrateur a été généré.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->loadCount('users');

        return view('super-admin.tenants.show', compact('tenant'));
    }

    public function activate(Tenant $tenant)
    {
        $wasPending = $tenant->status !== 'active';

        $tenant->update(['status' => 'active']);

        if ($wasPending && $tenant->owner_email) {
            try {
                Mail::to($tenant->owner_email)->send(
                    new AccountActivatedMail($tenant->name, $tenant->owner_name ?? 'là-bas')
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return back()->with('success', "{$tenant->name} a été activé.");
    }

    public function suspend(Tenant $tenant)
    {
        $tenant->update(['status' => 'suspended']);

        return back()->with('success', "{$tenant->name} a été suspendu. Ses employés ne pourront plus se connecter.");
    }
}