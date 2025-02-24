<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\{Session, App};
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\{Auth, Validator, Hash};

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
