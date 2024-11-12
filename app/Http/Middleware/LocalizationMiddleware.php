<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale') ?? 'en';
        Session::put('locale', $locale);
        App::setlocale($locale);

        return $next($request);
    }
}
