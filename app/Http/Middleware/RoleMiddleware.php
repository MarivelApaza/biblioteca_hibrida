<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar roles de Spatie (case-insensitive)
        $userRoles = $user->getRoleNames()->map(fn($r) => strtoupper($r))->toArray();
        $allowedRoles = array_map('strtoupper', $roles);

        if (empty(array_intersect($userRoles, $allowedRoles))) {
            // fallback: verifica columna 'rol'
            if (!in_array(strtoupper($user->rol ?? ''), $allowedRoles)) {
                abort(403, 'No tienes permiso para acceder.');
            }
        }

        return $next($request);
    }
}
