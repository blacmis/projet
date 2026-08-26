<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = (object) [
            'id' => 1,
            'name' => 'Admin User',
            'email' => 'admin@marketsmart.com',
            'phone' => '677 111 000',
            'role' => 'Administrator',
            'department' => 'Administration',
            'joined' => '01/01/2026',
            'login_count' => 210,
            'account_status' => 'Verified',
            'security_level' => 'High',
        ];

        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully (mock data).');
    }
}