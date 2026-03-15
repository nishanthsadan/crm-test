<?php

use Illuminate\Support\Facades\Route;
use Modules\Deals\Http\Controllers\DealController;

Route::middleware(['auth', 'module.enabled:Deals'])->prefix('deals')->name('deals.')->group(function () {
    Route::get('/', [DealController::class, 'index'])->name('index');
    Route::get('/pipeline', [DealController::class, 'pipeline'])->name('pipeline');
    Route::get('/create', [DealController::class, 'create'])->name('create');
    Route::post('/', [DealController::class, 'store'])->name('store');
    Route::get('/{deal}', [DealController::class, 'show'])->name('show');
    Route::get('/{deal}/edit', [DealController::class, 'edit'])->name('edit');
    Route::put('/{deal}', [DealController::class, 'update'])->name('update');
    Route::delete('/{deal}', [DealController::class, 'destroy'])->name('destroy');
    Route::patch('/{deal}/stage', [DealController::class, 'updateStage'])->name('update-stage');
});
