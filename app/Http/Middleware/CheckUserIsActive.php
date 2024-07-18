<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserIsActive
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->active) {
            // Si el usuario está autenticado pero no está activo, cerramos su sesión
            auth()->logout();
            return redirect('/login')->with('error', 'Tu cuenta está desactivada.');
        }

        return $next($request);
    }
}
