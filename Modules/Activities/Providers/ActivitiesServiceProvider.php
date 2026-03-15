<?php

namespace Modules\Activities\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Activities\Http\Livewire\ActivityTable;

class ActivitiesServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'activities');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Livewire::component('activities.activity-table', ActivityTable::class);
    }
}
