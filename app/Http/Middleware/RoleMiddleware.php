<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, string $role) {
        if (!Auth::check() || Auth::user()->role !== $role || !Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('login')->withErrors(['email' => 'Acceso denegado o usuario inactivo.']);
        }
        return $next($request);
    }
}