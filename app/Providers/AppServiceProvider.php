<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use App\View\Components\MainLayout;
use App\View\Components\CashierLayout;
use App\View\Components\ErrorLayout;



class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

       public function boot(UrlGenerator $url)
    {
     
    
    
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }
    }

}