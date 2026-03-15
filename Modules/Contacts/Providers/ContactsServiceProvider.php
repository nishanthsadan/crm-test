<?php

namespace Modules\Contacts\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Modules\Contacts\Http\Livewire\ContactTable;

class ContactsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        });
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'contacts');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        Livewire::component('contacts.contact-table', ContactTable::class);
    }
}
