<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if (strtolower((string) $request->user()->role) !== strtolower($role)) {
            abort(403, 'No tienes permisos para acceder a este módulo.');
        }

        return $next($request);
    }
}