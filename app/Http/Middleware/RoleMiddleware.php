<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $rolPermitido): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->rol !== $rolPermitido) {
            abort(403, 'Acceso denegado (Error 403): Tu perfil no tiene permisos para acceder al modulo de ' . strtoupper($rolPermitido));
        }

        return $next($request);
    }
}
