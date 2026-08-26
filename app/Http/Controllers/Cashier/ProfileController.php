<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = (object) [
            'id' => 1,
            'name' => 'Cashier User',
            'email' => 'cashier@marketsmart.com',
            'phone' => '677 000 000',
            'role' => 'Caissier',
            'department' => 'Point de vente',
            'joined' => '01/03/2026',
            'login_count' => 87,
            'account_status' => 'Vérifié',
            'security_level' => 'Haut',
        ];

        return view('cashier.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        return back()->with('success', 'Profile updated successfully (données fictives).');
    }
}