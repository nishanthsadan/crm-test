<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force all URL generation to use APP_URL as base (fixes subdirectory installs)
        URL::forceRootUrl(config('app.url'));

        Schema::defaultStringLength(160);

        Paginator::useBootstrapFive();

        // Register global blade components
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.auth', 'auth-layout');
    }
}
