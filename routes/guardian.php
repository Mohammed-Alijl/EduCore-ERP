<?php

use App\Http\Controllers\Guardian\Auth\GuardianAuthController;
use App\Http\Controllers\Guardian\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('guardian')->name('guardian.')->group(function () {
    // Guest Routes
    Route::middleware('guest:guardian')->group(function () {
        Route::get('login', [GuardianAuthController::class, 'create'])->name('login');
        Route::post('login', [GuardianAuthController::class, 'store'])->name('login.store');
    });

    // Authenticated Routes
    Route::middleware('auth:guardian')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [GuardianAuthController::class, 'destroy'])->name('logout');
    });
});
