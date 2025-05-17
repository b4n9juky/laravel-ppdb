<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Menambahkan log untuk memeriksa role user dan role yang dikirimkan oleh route
        logger('Role user:', ['from_user' => $user->role->value, 'from_route' => $role]);

        // Pastikan role yang dikirim cocok dengan enum value
        if (!$user || UserRole::tryFrom($user->role->value) !== UserRole::tryFrom($role)) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
