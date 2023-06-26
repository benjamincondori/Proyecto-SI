<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && (auth()->user()->rol->nombre === 'Administrador' 
                || auth()->user()->rol->nombre === 'Recepcionista')) {
            return $next($request);
        }

        return back()->with('error', 'Acceso restringido');
    }
}
