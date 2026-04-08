<?php

use App\Http\Controllers\Guardian\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('guardian')->name('guardian.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
