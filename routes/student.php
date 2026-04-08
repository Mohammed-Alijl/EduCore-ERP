<?php

use App\Http\Controllers\Site\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::middleware('throttle:web')->group(function () {
            Route::middleware('auth')->group(function () {
                Route::get('/dashboard', function () {
                    return view('student.dashboard');
                })->name('dashboard');

                Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
                Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
                Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            });
        });

        require __DIR__.'/auth.php';
    }
);
