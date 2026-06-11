<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Url;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Url $url): void
    {
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }
    }
}