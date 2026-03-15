<?php

use Illuminate\Support\Facades\Route;
use Modules\Accounts\Http\Controllers\AccountController;

Route::middleware(['auth', 'module.enabled:Accounts'])->prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/create', [AccountController::class, 'create'])->name('create');
    Route::post('/', [AccountController::class, 'store'])->name('store');
    Route::get('/{account}', [AccountController::class, 'show'])->name('show');
    Route::get('/{account}/edit', [AccountController::class, 'edit'])->name('edit');
    Route::put('/{account}', [AccountController::class, 'update'])->name('update');
    Route::delete('/{account}', [AccountController::class, 'destroy'])->name('destroy');
});
