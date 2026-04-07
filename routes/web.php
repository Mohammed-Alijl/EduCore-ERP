<?php

use App\Http\Controllers\Site\LandingController;
use App\Http\Controllers\Site\LegalController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {
        Route::middleware('throttle:web')->group(function () {

            Route::get('/', [LandingController::class, 'index'])->name('landing-page');

            // Legal Pages
            Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy-policy');
            Route::get('/terms-of-service', [LegalController::class, 'terms'])->name('terms-of-service');
            Route::get('/cookie-policy', [LegalController::class, 'cookie'])->name('cookie-policy');
        });
    }
);
