<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  string  ...$roles  Rôles autorisés (admin, manager, cashier)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pas connecté → login
        if (!session()->has('auth_user') || !session()->has('auth_role')) {
            return redirect()
                ->route('login')
                ->with('error', 'Vous devez vous connecter pour accéder à cette page.');
        }

        $role = session('auth_role');

        // Connecté mais mauvais rôle → 403
        if (!in_array($role, $roles, true)) {
            abort(403, 'Accès refusé : vous n\'avez pas la permission d\'accéder à cette page.');
        }

        return $next($request);
    }
}