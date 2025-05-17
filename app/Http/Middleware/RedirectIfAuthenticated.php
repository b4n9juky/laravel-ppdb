<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; // Gunakan ini

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();


            $redirect = match ($user->role) {
                \App\Enums\UserRole::ADMIN => route('admin.dashboard'),
                \App\Enums\UserRole::OPERATOR => route('operator.dashboard'),
                default => route('user.dashboard'),
            };

            return redirect()->intended($redirect);
        }

        return $next($request);
    }
}
