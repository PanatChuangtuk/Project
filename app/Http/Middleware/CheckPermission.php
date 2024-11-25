<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->hasPermission($request->route()->getName())) {
            return $next($request);
        }

        return redirect()->route('administrator.dashboard')->with('error', 'You do not have permission to access this page.');
    }
}

