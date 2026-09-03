<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AuditLogController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function unlock($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Utilisateur introuvable.');
        }

        $email = strtolower($user->email);

        $locks = session('login_locks', []);
        unset($locks[$email]);
        session(['login_locks' => $locks]);

        $attempts = session('login_attempts', []);
        unset($attempts[$email]);
        session(['login_attempts' => $attempts]);

        AuditLogController::log('USER_UNLOCK', 'Unlocked login for ' . $email);

        return back()->with('success', 'Compte déverrouillé : ' . $email);
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        $users = $query->orderBy('id')->get();

        return view('admin.users.index', [
            'users' => $users,
            'stats' => (object) [
                'total' => User::count(),
                'active' => User::where('status', 'active')->count(),
                'inactive' => User::where('status', 'inactive')->count(),
                'managers' => User::where('role', 'manager')->count(),
                'cashiers' => User::where('role', 'cashier')->count(),
            ],
        ]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'role' => 'required|in:manager,cashier,admin',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'role' => $request->role,
            'password' => $request->password, // auto-haché par le cast 'hashed' du modèle
            'status' => 'active',
        ]);

        AuditLogController::log('USER_CREATE', 'Created ' . $request->email . ' (' . $request->role . ')');

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Utilisateur introuvable.');
        }

        if ($user->email === session('auth_user')) {
            return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
        }

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        AuditLogController::log('USER_TOGGLE', 'User ID ' . $id . ' status changed');

        return back()->with('success', 'Statut utilisateur mis à jour.');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with('error', 'Utilisateur introuvable.');
        }

        if ($user->email === session('auth_user')) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        if ($user->role === 'admin') {
            return back()->with('error', 'Impossible de supprimer un compte admin.');
        }

        $user->delete();

        AuditLogController::log('USER_DELETE', 'Deleted user ID ' . $id);

        return back()->with('success', 'Utilisateur supprimé.');
    }
}