<?php

namespace Modules\Leads\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Leads\Http\Livewire\LeadTable;

class LeadsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'leads');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Livewire::component('leads.lead-table', LeadTable::class);
    }
}
