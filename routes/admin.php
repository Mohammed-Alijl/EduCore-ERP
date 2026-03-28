<?php

use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\ProfileController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\ClassroomController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\Finance\CurrencyController;
use App\Http\Controllers\Admin\Finance\FeeCategoryController;
use App\Http\Controllers\Admin\Finance\FeeController;
use App\Http\Controllers\Admin\Finance\InvoiceController;
use App\Http\Controllers\Admin\Finance\PaymentGatewayController;
use App\Http\Controllers\Admin\Finance\PaymentVoucherController;
use App\Http\Controllers\Admin\Finance\ReceiptController;
use App\Http\Controllers\Admin\Finance\StudentDiscountController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OnlineClassController;
use App\Http\Controllers\Admin\Reports\AttendanceReportController;
use App\Http\Controllers\Admin\Reports\FinancialReportController;
use App\Http\Controllers\Admin\Reports\GradesReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SpecializationController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\StudentPromotionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherAssignmentController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ],
    function () {

        Route::prefix('admin')->name('admin.')->group(function () {

            /* ===============================
        GUEST ROUTES
        =============================== */
            Route::middleware(['guest:admin', 'throttle:auth-attempts'])->group(function () {

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

            Route::middleware(['auth:admin', 'throttle:admin'])->group(function () {

                Route::middleware(['admin.verified'])->group(function () {

                    // ─── Dashboard ───────────────────────────────────────────────────────────────
                    Route::get('/', function () {
                        return view('admin.index');
                    })->name('dashboard');

                    // ─── Admins ───────────────────────────────────────────────────────────────
                    Route::resource('admins', AdminController::class)->except(['show', 'create', 'edit']);

                    // ─── Roles ───────────────────────────────────────────────────────────────
                    Route::resource('roles', RoleController::class);

                    // ─── Grades ───────────────────────────────────────────────────────────────
                    Route::resource('grades', GradeController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('grades')->name('grades.')->group(function () {
                        Route::get('archive', [GradeController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [GradeController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [GradeController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Classrooms ───────────────────────────────────────────────────────────────
                    Route::resource('classrooms', ClassroomController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('classrooms')->name('classrooms.')->group(function () {
                        Route::get('archive', [ClassroomController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [ClassroomController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [ClassroomController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('/by-grade', [ClassroomController::class, 'getByGrade'])->name('by-grade');
                    });

                    // ─── Sections ───────────────────────────────────────────────────────────────
                    Route::resource('sections', SectionController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('sections/')->name('sections.')->group(function () {
                        Route::get('archive', [SectionController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [SectionController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [SectionController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('by-classroom', [SectionController::class, 'getByClassroom'])->name('by-classroom');
                        Route::get('{section}/students', [SectionController::class, 'studentsOf'])->name('students');
                    });

                    // ─── Guardians ───────────────────────────────────────────────────────────────
                    Route::resource('guardians', GuardianController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('guardians/')->name('guardians.')->group(function () {
                        Route::get('archive', [GuardianController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [GuardianController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [GuardianController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Students ───────────────────────────────────────────────────────────────
                    Route::resource('students', StudentController::class)->except(['show', 'create']);
                    Route::prefix('students/')->name('students.')->group(function () {
                        Route::get('promotions', [StudentPromotionController::class, 'index'])->name('promotions.index');
                        Route::post('promotions', [StudentPromotionController::class, 'store'])->name('promotions.store');
                        Route::get('archive', [StudentController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [StudentController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [StudentController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('/next-code', [StudentController::class, 'getNextStudentCode'])->name('next-code');
                        Route::post('attachments/destroy', [StudentController::class, 'deleteAttachment'])->name('attachment.destroy');
                        Route::get('search', [StudentController::class, 'search'])->name('search');
                        Route::get('{student}/finance', [StudentController::class, 'finance'])->name('finance');
                        Route::get('{student}/grades', [StudentController::class, 'grades'])->name('grades');
                    });

                    // ─── Teachers ───────────────────────────────────────────────────────────────
                    Route::resource('teachers', TeacherController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('teachers/')->name('teachers.')->group(function () {
                        Route::delete('attachments/{id}', [TeacherController::class, 'deleteAttachment'])->name('attachments.destroy');
                        Route::get('archive', [TeacherController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [TeacherController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [TeacherController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── HR Employees ─────────────────────────────────────────────────────────────
                    Route::resource('employees', EmployeeController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('employees/')->name('employees.')->group(function () {
                        Route::delete('attachments/{id}', [EmployeeController::class, 'deleteAttachment'])->name('attachments.destroy');
                        Route::get('archive', [EmployeeController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [EmployeeController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [EmployeeController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Teacher Assignments ───────────────────────────────────────────────────────────────
                    Route::resource('teacher_assignments', TeacherAssignmentController::class)->except(['show', 'create']);

                    // ─── Finance (Fees & Fee Categories) ─────────────────────────────────────────────────
                    Route::prefix('fee_categories')->name('fee_categories.')->group(function () {
                        Route::get('/datatable', [FeeCategoryController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('fee_categories', FeeCategoryController::class)->except(['show', 'create', 'edit']);

                    Route::prefix('fees')->name('fees.')->group(function () {
                        Route::get('/datatable', [FeeController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('fees', FeeController::class)->except(['show', 'create', 'edit']);

                    // ─── Invoices ───────────────────────────────────────────────────────────────
                    Route::prefix('invoices')->name('invoices.')->group(function () {
                        Route::get('/datatable', [InvoiceController::class, 'datatable'])->name('datatable');
                        Route::get('/{invoice}/print', [InvoiceController::class, 'print'])->name('print');
                    });
                    Route::resource('invoices', InvoiceController::class)->except(['show', 'create', 'edit']);

                    // ─── Receipts ───────────────────────────────────────────────────────────────
                    Route::prefix('receipts')->name('receipts.')->group(function () {
                        Route::get('/datatable', [ReceiptController::class, 'datatable'])->name('datatable');
                        Route::get('/{receipt}/print', [ReceiptController::class, 'print'])->name('print');
                    });
                    Route::resource('receipts', ReceiptController::class)->except(['show', 'create', 'edit']);

                    // ─── Payment Vouchers ──────────────────────────────────────────────────────────
                    Route::prefix('payment_vouchers')->name('payment_vouchers.')->group(function () {
                        Route::get('/datatable', [PaymentVoucherController::class, 'datatable'])->name('datatable');
                        Route::get('/{payment_voucher}/print', [PaymentVoucherController::class, 'print'])->name('print');
                    });
                    Route::resource('payment_vouchers', PaymentVoucherController::class)->except(['show', 'create', 'edit']);

                    // ─── Student Discounts ─────────────────────────────────────────────────────────
                    Route::prefix('student_discounts')->name('student_discounts.')->group(function () {
                        Route::get('/datatable', [StudentDiscountController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('student_discounts', StudentDiscountController::class)->except(['show', 'create', 'edit']);

                    // ─── Currencies ─────────────────────────────────────────────────────────────────
                    Route::prefix('currencies')->name('currencies.')->group(function () {
                        Route::get('/datatable', [CurrencyController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('currencies', CurrencyController::class)->except(['show', 'create', 'edit']);

                    // ─── Payment Gateways ──────────────────────────────────────────────────────────
                    Route::prefix('payment_gateways')->name('payment_gateways.')->group(function () {
                        Route::get('/settings-schema', [PaymentGatewayController::class, 'settingsSchema'])->name('settings-schema');
                        Route::post('/activate', [PaymentGatewayController::class, 'activate'])->name('activate');
                        Route::patch('/{payment_gateway}/toggle-status', [PaymentGatewayController::class, 'toggleStatus'])->name('toggle-status');
                    });
                    Route::resource('payment_gateways', PaymentGatewayController::class)->only(['index', 'update']);

                    // ─── Reports ───────────────────────────────────────────────────────────────
                    Route::prefix('reports')->name('reports.')->group(function () {
                        // Financial Reports
                        Route::prefix('financial')->name('financial.')->group(function () {
                            Route::get('/outstanding-balances', [FinancialReportController::class, 'outstandingBalances'])->name('outstanding-balances');
                        });

                        // Grades Reports
                        Route::prefix('grades')->name('grades.')->group(function () {
                            Route::get('/', [GradesReportController::class, 'index'])->name('index');
                            Route::get('/subjects/filter', [GradesReportController::class, 'getSubjects'])->name('subjects');
                            Route::get('/exams/filter', [GradesReportController::class, 'getExams'])->name('exams');
                        });

                        // Attendance Reports
                        Route::prefix('attendance')->name('attendance.')->group(function () {
                            Route::get('/', [AttendanceReportController::class, 'index'])->name('index');
                        });
                    });

                    // ─── Specializations ───────────────────────────────────────────────────────────────
                    Route::resource('specializations', SpecializationController::class)->except(['show', 'create', 'edit']);

                    // ─── Departments ───────────────────────────────────────────────────────────────
                    Route::resource('departments', DepartmentController::class)->except(['show', 'create', 'edit']);

                    // ─── Designations ───────────────────────────────────────────────────────────────
                    Route::resource('designations', DesignationController::class)->except(['show', 'create', 'edit']);

                    // ─── Profile ───────────────────────────────────────────────────────────────
                    Route::prefix('profile')->name('profile.')->group(function () {
                        Route::get('/', [ProfileController::class, 'index'])->name('index');
                        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
                        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
                        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar');
                    });

                    // ─── Subject ───────────────────────────────────────────────────────────────
                    Route::resource('subjects', SubjectController::class)->except(['show', 'create', 'edit']);
                    Route::prefix('subjects/')->name('subjects.')->group(function () {
                        Route::get('archive', [SubjectController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [SubjectController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [SubjectController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Attendance ───────────────────────────────────────────────────────────────
                    Route::prefix('attendances')->name('attendances.')->group(function () {
                        Route::get('/', [AttendanceController::class, 'index'])->name('index');
                        Route::get('/students', [AttendanceController::class, 'getStudents'])->name('students');
                        Route::post('/', [AttendanceController::class, 'store'])->name('store');
                        Route::post('/print-section', [AttendanceController::class, 'printSectionAttendance'])->name('print-section');
                    });

                    // ─── Exams ───────────────────────────────────────────────────────────────
                    Route::prefix('exams')->name('exams.')->group(function () {
                        Route::get('/', [ExamController::class, 'index'])->name('index');
                        Route::get('/datatable', [ExamController::class, 'datatable'])->name('datatable');
                        Route::get('/{exam}/attempts', [ExamController::class, 'showAttempts'])->name('attempts');
                        Route::post('/{exam}/reset-attempt', [ExamController::class, 'resetAttempt'])->name('resetAttempt');
                    });

                    // ─── Online Classes ───────────────────────────────────────────────────────────────
                    Route::prefix('online_classes')->name('online_classes.')->group(function () {
                        Route::get('/datatable', [OnlineClassController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('online_classes', OnlineClassController::class)->except(['create', 'edit']);

                    // ─── Library (Books) ───────────────────────────────────────────────────────────────
                    Route::prefix('library')->name('library.')->group(function () {
                        Route::get('/', [\App\Http\Controllers\Admin\BookController::class, 'index'])->name('index');
                        Route::get('/datatable', [\App\Http\Controllers\Admin\BookController::class, 'datatable'])->name('datatable');
                        Route::get('/download/{book}', [\App\Http\Controllers\Admin\BookController::class, 'download'])->name('download');
                        Route::delete('/destroy/{book}', [\App\Http\Controllers\Admin\BookController::class, 'destroy'])->name('destroy');
                    });

                    // ─── Helper Routes for Dependent Dropdowns ──────────────────────────────────────────
                    Route::get('get-classrooms', [ClassroomController::class, 'getByGrade'])->name('get_classrooms');
                    Route::get('get-sections', [SectionController::class, 'getByClassroom'])->name('get_sections');
                    Route::get('get-sections-by-grade', [SectionController::class, 'getByGrade'])->name('get_sections_by_grade');
                    Route::get('get-designations', [DesignationController::class, 'getByDepartment'])->name('get_designations');

                    // ─── Academic Year ───────────────────────────────────────────────────────────────
                    Route::resource('academic_years', AcademicYearController::class)->except(['show', 'create', 'edit', 'destroy']);

                    // ─── Notifications ───────────────────────────────────────────────────────────────
                    Route::prefix('notifications')->name('notifications.')->group(function () {
                        Route::get('/', [NotificationController::class, 'index'])->name('index');
                        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
                        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
                        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
                        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
                    });

                    // ─── Exports ───────────────────────────────────────────────────────────────
                    Route::prefix('exports')->name('exports.')->group(function () {
                        Route::get('/download', [NotificationController::class, 'downloadExport'])->name('download');
                        Route::post('/attendance', [AttendanceReportController::class, 'requestExport'])->name('attendance');
                        Route::post('/attendance-pdf', [AttendanceReportController::class, 'requestPdfExport'])->name('attendance-pdf');
                        Route::post('/grades', [GradesReportController::class, 'requestExport'])->name('grades');
                        Route::post('/grades-pdf', [GradesReportController::class, 'requestPdfExport'])->name('grades-pdf');
                        Route::post('/financial', [FinancialReportController::class, 'requestExport'])->name('financial');
                        Route::post('/financial-pdf', [FinancialReportController::class, 'requestPdfExport'])->name('financial-pdf');
                    });

                    // ─── Activity Logs ───────────────────────────────────────────────────────────────
                    Route::prefix('activity_logs')->name('activity_logs.')->group(function () {
                        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
                        Route::get('/datatable', [ActivityLogController::class, 'datatable'])->name('datatable');
                        Route::get('/subject/logs', [ActivityLogController::class, 'forSubject'])->name('for-subject');
                        Route::get('/causer/logs', [ActivityLogController::class, 'byCauser'])->name('by-causer');
                        Route::get('/statistics/summary', [ActivityLogController::class, 'statistics'])->name('statistics');
                        Route::post('/cleanup', [ActivityLogController::class, 'cleanup'])->name('cleanup');
                        Route::get('/{id}', [ActivityLogController::class, 'show'])->name('show')->where('id', '[0-9]+');
                    });
                });
                Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
            });
        });
    }
);
