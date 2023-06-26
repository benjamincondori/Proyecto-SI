<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->rol->nombre === 'Instructor') {
            return $next($request);
        }
        
        return back()->with('error', 'Acceso restringido');
    }
}
