<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminOnly
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'Super Admin') {
            return $next($request);
        }
        
        return redirect()->route('administrator.dashboard')->with('error', 'You do not have permission to access this page.');
    }
}
