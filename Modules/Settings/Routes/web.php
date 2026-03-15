<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\SettingController;

Route::middleware(['auth', 'module.enabled:Settings'])->prefix('settings')->name('settings.')->group(function () {
    // Profile (all authenticated users)
    Route::get('/profile', [SettingController::class, 'profile'])->name('profile');
    Route::put('/profile', [SettingController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [SettingController::class, 'updatePassword'])->name('profile.password');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');

        // User Management
        Route::get('/users', [SettingController::class, 'users'])->name('users.index');
        Route::get('/users/create', [SettingController::class, 'createUser'])->name('users.create');
        Route::post('/users', [SettingController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [SettingController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [SettingController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [SettingController::class, 'destroyUser'])->name('users.destroy');

        // Module Management
        Route::get('/modules', [SettingController::class, 'modules'])->name('modules');
        Route::post('/modules/{module}/toggle', [SettingController::class, 'toggleModule'])->name('modules.toggle');
    });
});
