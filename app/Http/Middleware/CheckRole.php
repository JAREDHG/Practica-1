<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar que el usuario esté logueado
        if (!auth()->check()) {
            abort(403, 'Unauthorized access');
        }

        // Se itera sobre la lista de roles permitidos en la ruta
        foreach ($roles as $role) {
            // Si el usuario tiene al menos uno de los roles permitidos, pasa
            if (auth()->user()->hasRole(trim($role))) {
                return $next($request);
            }
        }

        // Si terminó el ciclo y no coincidió ningún rol, se bloquea el acceso
        abort(403, 'Unauthorized access');
    }
}