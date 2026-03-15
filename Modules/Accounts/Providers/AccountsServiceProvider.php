<?php

namespace Modules\Accounts\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Accounts\Http\Livewire\AccountTable;

class AccountsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'accounts');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Livewire::component('accounts.account-table', AccountTable::class);
    }
}
