<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportController;

Route::middleware(['auth', 'module.enabled:Reports'])->prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/leads', [ReportController::class, 'leads'])->name('leads');
    Route::get('/deals', [ReportController::class, 'deals'])->name('deals');
    Route::get('/activities', [ReportController::class, 'activities'])->name('activities');
    Route::get('/export/leads', [ReportController::class, 'exportLeads'])->name('export.leads');
    Route::get('/export/deals', [ReportController::class, 'exportDeals'])->name('export.deals');
});
