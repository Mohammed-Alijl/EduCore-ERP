<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentPromotionController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

    Route::prefix('admin')->name('admin.')->group(function() {

        /* ===============================
        GUEST ROUTES
        =============================== */
        Route::middleware(['guest:admin','throttle:auth-attempts'])->group(function () {

            // ─── Admin Login ───────────────────────────────────────────────────────────────
            Route::get('login', [AdminAuthController::class, 'create'])->name('login');
            Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');

            // ─── Admin Forgot Password ───────────────────────────────────────────────────────────────
            Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
            Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

            // ─── Admin Reset Password ───────────────────────────────────────────────────────────────
            Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
            Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
        });

        /* ===============================
        Auth ROUTES
        =============================== */
        Route::middleware('auth:admin')->group(function () {

            // ─── Verify Email  ───────────────────────────────────────────────────────────────
            Route::get('verify-email', [VerifyEmailController::class, '__invoke'])->name('verification.notice');
            Route::post('email/verification-notification', [VerifyEmailController::class, 'store'])
                ->middleware('throttle:6,1')->name('verification.send');
            Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
                ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        });

        Route::middleware(['auth:admin','throttle:admin'])->group(function () {

            Route::middleware(['admin.verified'])->group(function () {

                // ─── Dashboard ───────────────────────────────────────────────────────────────
                Route::get('/', function () { return view('admin.index');})->name('dashboard');

                // ─── Admins ───────────────────────────────────────────────────────────────
                Route::resource('admins', AdminController::class)->except(['show','create','edit']);

                // ─── Roles ───────────────────────────────────────────────────────────────
                Route::resource('roles', RoleController::class);

                // ─── Grades ───────────────────────────────────────────────────────────────
                Route::resource('grades', GradeController::class)->except(['show','create','edit']);
                Route::prefix('grades')->name('grades.')->group(function () {
                    Route::get('archive',[GradeController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[GradeController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[GradeController::class, 'forceDelete'])->name('forceDelete');
                });

                // ─── Classrooms ───────────────────────────────────────────────────────────────
                Route::resource('classrooms', ClassroomController::class)->except(['show','create','edit']);
                Route::prefix('classrooms')->name('classrooms.')->group(function () {
                   Route::get('archive',[ClassroomController::class,'archive'])->name('archived');
                   Route::post('restore/{id}',[ClassroomController::class, 'restore'])->name('restore');
                   Route::delete('force-delete/{id}',[ClassroomController::class, 'forceDelete'])->name('forceDelete');
                   Route::get('/by-grade', [ClassroomController::class, 'getByGrade'])->name('by-grade');
                });

                // ─── Sections ───────────────────────────────────────────────────────────────
                Route::resource('sections', SectionController::class)->except(['show','create','edit']);
                Route::prefix('sections/')->name('sections.')->group(function () {
                    Route::get('archive',[SectionController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[SectionController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[SectionController::class, 'forceDelete'])->name('forceDelete');
                    Route::get('by-classroom', [SectionController::class, 'getByClassroom'])->name('by-classroom');
                });

                // ─── Guardians ───────────────────────────────────────────────────────────────
                Route::resource('guardians',GuardianController::class)->except(['show','create','edit']);
                Route::prefix('guardians/')->name('guardians.')->group(function () {
                    Route::get('archive',[GuardianController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[GuardianController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[GuardianController::class, 'forceDelete'])->name('forceDelete');
                });

                // ─── Students ───────────────────────────────────────────────────────────────
                Route::resource('students',StudentController::class)->except(['show','create','edit']);
                Route::prefix('students/')->name('students.')->group(function () {
                    Route::get('promotions', [StudentPromotionController::class, 'index'])->name('promotions.index');
                    Route::post('promotions', [StudentPromotionController::class, 'store'])->name('promotions.store');
                    Route::get('archive',[StudentController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[StudentController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[StudentController::class, 'forceDelete'])->name('forceDelete');
                    Route::get('/next-code', [StudentController::class, 'getNextStudentCode'])->name('next-code');
                });

                // ─── Teachers ───────────────────────────────────────────────────────────────
                Route::resource('teachers',TeacherController::class)->except(['show','create','edit']);
                Route::prefix('teachers/')->name('teachers.')->group(function () {
                    Route::delete('attachments/{id}', [TeacherController::class, 'deleteAttachment'])->name('attachments.destroy');
                    Route::get('archive',[TeacherController::class,'archive'])->name('archived');
                    Route::post('restore/{id}',[TeacherController::class, 'restore'])->name('restore');
                    Route::delete('force-delete/{id}',[TeacherController::class, 'forceDelete'])->name('forceDelete');
                });

                // ─── Specializations ───────────────────────────────────────────────────────────────
                Route::resource('teachers',TeacherController::class)->except(['show','create','edit']);

            });
            Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
        });

    });
});
