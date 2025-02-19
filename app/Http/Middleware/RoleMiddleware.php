<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\{Session, App};
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\{Auth, Validator, Hash};

class RoleMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('member')->check()->role !== 'admin') {
            return redirect()->route('profile');
        }

        return $next($request);
    }
}
