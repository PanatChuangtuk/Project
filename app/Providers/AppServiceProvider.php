<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{View, URL};

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $host = request()->getHost();
        if (app()->environment('production') || str_contains($host, 'ngrok') || str_contains($host, 'amazonaws')) {
            URL::forceScheme('https');
        }
        Paginator::defaultView('administrator.pagination');
    }
}
