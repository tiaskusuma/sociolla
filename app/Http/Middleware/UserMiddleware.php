<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role === 'petugas') {
                return redirect()->route('petugas.dashboard');
            }
        }

        return $next($request);
    }
}
