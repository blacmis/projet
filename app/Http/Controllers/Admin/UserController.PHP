<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuditLogController;
class UserController extends Controller
{
    public function unlock($id)
{
    $users = $this->getUsers();
    $email = null;
    foreach ($users as $u) {
        if ((int) $u['id'] === (int) $id) {
            $email = strtolower($u['email']);
            break;
        }
    }
    if (!$email) {
        return back()->with('error', 'Utilisateur introuvable.');
    }
    $locks = session('login_locks', []);
    unset($locks[$email]);
    session(['login_locks' => $locks]);
    $attempts = session('login_attempts', []);
    unset($attempts[$email]);
    session(['login_attempts' => $attempts]);
    AuditLogController::log('USER_UNLOCK', 'Unlocked login for '.$email);
    return back()->with('success', 'Compte déverrouillé : '.$email);
}
    /** Liste de départ (mock) */
    private function defaultUsers(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Admin User',
                'email' => 'admin@marketsmart.com',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => '01/01/2026',
            ],
            [
                'id' => 2,
                'name' => 'Inventory Manager',
                'email' => 'manager@marketsmart.com',
                'role' => 'manager',
                'status' => 'active',
                'created_at' => '05/01/2026',
            ],
            [
                'id' => 3,
                'name' => 'Ange Cashier',
                'email' => 'cashier@marketsmart.com',
                'role' => 'cashier',
                'status' => 'active',
                'created_at' => '10/01/2026',
            ],
            [
                'id' => 4,
                'name' => 'Hillman Stock',
                'email' => 'hillman@marketsmart.com',
                'role' => 'manager',
                'status' => 'active',
                'created_at' => '15/02/2026',
            ],
            [
                'id' => 5,
                'name' => 'Jean Caisse',
                'email' => 'jean@marketsmart.com',
                'role' => 'cashier',
                'status' => 'inactive',
                'created_at' => '20/03/2026',
            ],
        ];
    }
    private function getUsers(): array
    {
        if (!session()->has('admin_users')) {
            session(['admin_users' => $this->defaultUsers()]);
        }
        return session('admin_users');
    }
    private function saveUsers(array $users): void
    {
        session(['admin_users' => array_values($users)]);
    }
    public function index(Request $request)
    {
        $users = collect($this->getUsers());
        if ($request->filled('role') && $request->role !== 'all') {
            $users = $users->where('role', $request->role)->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $users = $users->where('status', $request->status)->values();
        }
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $users = $users->filter(function ($u) use ($q) {
                return str_contains(strtolower($u['name']), $q)
                    || str_contains(strtolower($u['email']), $q);
            })->values();
        }
        return view('admin.users.index', [
            'users' => $users,
            'stats' => (object) [
                'total' => count($this->getUsers()),
                'active' => collect($this->getUsers())->where('status', 'active')->count(),
                'inactive' => collect($this->getUsers())->where('status', 'inactive')->count(),
                'managers' => collect($this->getUsers())->where('role', 'manager')->count(),
                'cashiers' => collect($this->getUsers())->where('role', 'cashier')->count(),
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
            'email' => 'required|email|max:150',
            'role' => 'required|in:manager,cashier,admin',
            'password' => 'required|string|min:6',
        ]);
        $users = $this->getUsers();
        // Email déjà utilisé ?
        foreach ($users as $u) {
            if (strtolower($u['email']) === strtolower($request->email)) {
                return back()->withInput()->with('error', 'Cet email est déjà utilisé.');
            }
        }
        $newId = collect($users)->max('id') + 1;
        $users[] = [
            'id' => $newId,
            'name' => $request->name,
            'email' => strtolower($request->email),
            'role' => $request->role,
            'status' => 'active',
            'created_at' => now()->format('d/m/Y'),
        ];
        $this->saveUsers($users);
            AuditLogController::log('USER_CREATE', 'Created '.$request->email.' ('.$request->role.')');
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Utilisateur créé avec succès (mock).');
    }
    public function toggleStatus($id)
    {
        $users = $this->getUsers();
        $found = false;
        foreach ($users as $i => $u) {
            if ((int) $u['id'] === (int) $id) {
                // Ne pas se désactiver soi-même (admin connecté)
                if ($u['email'] === session('auth_user')) {
                    return back()->with('error', 'Vous ne pouvez pas désactiver votre propre compte.');
                }
                $users[$i]['status'] = $u['status'] === 'active' ? 'inactive' : 'active';
                $found = true;
                break;
            }
        }
        if (!$found) {
            return back()->with('error', 'Utilisateur introuvable.');
        }
        $this->saveUsers($users);
            AuditLogController::log('USER_TOGGLE', 'User ID '.$id.' status changed');
            return back()->with('success', 'Statut utilisateur mis à jour.');
        
    }
    public function destroy($id)
    {
        $users = $this->getUsers();
        foreach ($users as $i => $u) {
            if ((int) $u['id'] === (int) $id) {
                if ($u['email'] === session('auth_user')) {
                    return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
                }
                if ($u['role'] === 'admin') {
                    return back()->with('error', 'Impossible de supprimer un compte admin (mock).');
                }
                unset($users[$i]);
                $this->saveUsers($users);
                    AuditLogController::log('USER_DELETE', 'Deleted user ID '.$id);
                    return back()->with('success', 'Utilisateur supprimé.');
            }
        }
        return back()->with('error', 'Utilisateur introuvable.');
    }
}