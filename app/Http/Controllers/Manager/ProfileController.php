<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\HandlesProfilePhoto;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use HandlesProfilePhoto;

    private function currentUser(): ?User
    {
        return User::where('email', session('auth_user'))->first();
    }

    public function index()
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $loginCount = ActivityLog::where('user_name', $authUser->email)
            ->where('activity_type', 'login')
            ->count();

        $user = (object) [
            'id' => $authUser->id,
            'name' => $authUser->name,
            'email' => $authUser->email,
            'phone' => $authUser->phone ?? '—',
            'role' => 'Inventory Manager',
            'department' => $authUser->department ?? 'Inventory Department',
            'joined' => $authUser->created_at->format('d/m/Y'),
            'login_count' => $loginCount,
            'account_status' => $authUser->status === 'active' ? 'Verified' : 'Inactive',
            'security_level' => 'Standard',
            'photo' => $authUser->photo,
        ];

        return view('manager.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $authUser->id,
            'phone' => 'nullable|string|max:30',
        ]);

        $authUser->update([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'phone' => $request->phone,
        ]);

        session(['auth_user' => $authUser->email]);

        return redirect()->route('manager.profile')->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePhoto(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $this->storeProfilePhoto($request, $authUser);

        return back()->with('success', 'Photo de profil mise à jour.');
    }
}