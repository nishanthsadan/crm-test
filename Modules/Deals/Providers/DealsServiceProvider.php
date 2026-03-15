<?php

namespace Modules\Deals\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Deals\Http\Livewire\DealTable;

class DealsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'deals');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Livewire::component('deals.deal-table', DealTable::class);
    }
}
