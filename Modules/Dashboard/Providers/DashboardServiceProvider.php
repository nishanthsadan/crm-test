<?php

namespace Modules\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class DashboardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'dashboard');
    }
}
