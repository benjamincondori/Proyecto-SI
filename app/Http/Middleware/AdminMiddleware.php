<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->rol->nombre !== 'Cliente' 
                && auth()->user()->rol->nombre !== 'Instructor') {
            return $next($request);
        }

        return redirect('/');
    }
}
