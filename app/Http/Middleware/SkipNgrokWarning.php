<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkipNgrokWarning
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // เงื่อนไข: ถ้า URL มาจาก ngrok
        if (str_contains($request->getHost(), 'ngrok-free.app')) {
            $response->headers->set('ngrok-skip-browser-warning', 'true');
        }

        return $response;
    }
}
