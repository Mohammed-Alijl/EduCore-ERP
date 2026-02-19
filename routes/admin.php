<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\GuardianController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

    Route::prefix('admin')->name('admin.')->group(function() {

        Route::middleware(['guest:admin','throttle:auth-attempts'])->group(function () {
            Route::get('login', [AdminAuthController::class, 'create'])->name('login');
            Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');

            Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
            Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
            Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
        });

        Route::middleware('auth:admin')->group(function () {
            Route::get('verify-email', [VerifyEmailController::class, '__invoke'])->name('verification.notice');
            Route::post('email/verification-notification', [VerifyEmailController::class, 'store'])
                ->middleware('throttle:6,1')->name('verification.send');
            Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
                ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        });

        Route::middleware(['auth:admin','throttle:admin'])->group(function () {

            Route::middleware(['admin.verified'])->group(function () {
                Route::get('/', function () { return view('admin.index');})->name('dashboard');
                Route::resource('admins', AdminController::class)->except(['show','create','edit']);
                Route::resource('roles', RoleController::class);
                Route::resource('grades', GradeController::class)->except(['show','create','edit']);
                Route::prefix('grades')->name('grades.')->group(function () {
                    Route::get('archive',[GradeController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[GradeController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[GradeController::class, 'forceDelete'])->name('forceDelete');
                });
                Route::resource('classrooms', ClassroomController::class)->except(['show','create','edit']);
                Route::prefix('classrooms')->name('classrooms.')->group(function () {
                   Route::get('archive',[ClassroomController::class,'archive'])->name('archived');
                   Route::post('restore/{id}',[ClassroomController::class, 'restore'])->name('restore');
                   Route::delete('force-delete/{id}',[ClassroomController::class, 'forceDelete'])->name('forceDelete');
                });
                Route::resource('sections', SectionController::class)->except(['show','create','edit']);
                Route::get('/classes/{id}', [SectionController::class, 'getClassrooms']);
                Route::prefix('sections/')->name('sections.')->group(function () {
                    Route::get('archive',[SectionController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[SectionController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[SectionController::class, 'forceDelete'])->name('forceDelete');
                });
                Route::resource('guardians',GuardianController::class)->except(['show','create','edit']);
                Route::prefix('guardians/')->name('guardians.')->group(function () {
                    Route::get('archive',[GuardianController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[GuardianController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[GuardianController::class, 'forceDelete'])->name('forceDelete');
                });
            });
            Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
        });

    });
});
