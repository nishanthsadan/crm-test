<?php

use Illuminate\Support\Facades\Route;
use Modules\Leads\Http\Controllers\LeadController;

Route::middleware(['auth', 'module.enabled:Leads'])->prefix('leads')->name('leads.')->group(function () {
    Route::get('/', [LeadController::class, 'index'])->name('index');
    Route::get('/create', [LeadController::class, 'create'])->name('create');
    Route::post('/', [LeadController::class, 'store'])->name('store');
    Route::get('/{lead}', [LeadController::class, 'show'])->name('show');
    Route::get('/{lead}/edit', [LeadController::class, 'edit'])->name('edit');
    Route::put('/{lead}', [LeadController::class, 'update'])->name('update');
    Route::delete('/{lead}', [LeadController::class, 'destroy'])->name('destroy');
    Route::post('/{lead}/convert', [LeadController::class, 'convert'])->name('convert');
});
