<?php

use App\Http\Controllers\Admin\Academic\AcademicYearController;
use App\Http\Controllers\Admin\Academic\ClassroomController;
use App\Http\Controllers\Admin\Academic\GradeController;
use App\Http\Controllers\Admin\Academic\SectionController;
use App\Http\Controllers\Admin\LMS\SubjectController;
use App\Http\Controllers\Admin\System\ActivityLogController;
use App\Http\Controllers\Admin\Users\AdminController;
use App\Http\Controllers\Admin\HR\AttendanceController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\ProfileController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\LMS\BookController;
use App\Http\Controllers\Admin\CMS\CmsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HR\DepartmentController;
use App\Http\Controllers\Admin\HR\DesignationController;
use App\Http\Controllers\Admin\Users\EmployeeController;
use App\Http\Controllers\Admin\Exams\ExamController;
use App\Http\Controllers\Admin\Finance\CurrencyController;
use App\Http\Controllers\Admin\Finance\FeeCategoryController;
use App\Http\Controllers\Admin\Finance\FeeController;
use App\Http\Controllers\Admin\Finance\InvoiceController;
use App\Http\Controllers\Admin\Finance\PaymentGatewayController;
use App\Http\Controllers\Admin\Finance\PaymentVoucherController;
use App\Http\Controllers\Admin\Finance\ReceiptController;
use App\Http\Controllers\Admin\Finance\StudentDiscountController;
use App\Http\Controllers\Admin\Students\GraduationController;
use App\Http\Controllers\Admin\Users\GuardianController;
use App\Http\Controllers\Admin\System\NotificationController;
use App\Http\Controllers\Admin\LMS\OnlineClassController;
use App\Http\Controllers\Admin\Students\PromotionHistoryController;
use App\Http\Controllers\Admin\Reports\AttendanceReportController;
use App\Http\Controllers\Admin\Reports\FinancialReportController;
use App\Http\Controllers\Admin\Reports\GradesReportController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\Schedule\ClassPeriodController;
use App\Http\Controllers\Admin\Schedule\TimetableController;
use App\Http\Controllers\Admin\Settings\DayOfWeekController;
use App\Http\Controllers\Admin\Settings\ExternalApiSettingController;
use App\Http\Controllers\Admin\Settings\GeneralSettingController;
use App\Http\Controllers\Admin\HR\SpecializationController;
use App\Http\Controllers\Admin\Users\StudentController;
use App\Http\Controllers\Admin\Students\StudentPromotionController;
use App\Http\Controllers\Admin\LMS\TeacherAssignmentController;
use App\Http\Controllers\Admin\Users\TeacherController;
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
                    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

                    // ─── Admins ───────────────────────────────────────────────────────────────
                    Route::resource('admins', AdminController::class)->names('Users.admins')->except(['show', 'create', 'edit']);

                    // ─── Roles ───────────────────────────────────────────────────────────────
                    Route::resource('roles', RoleController::class)->names('System.roles')->except(['show']);

                    // ─── Grades ───────────────────────────────────────────────────────────────
                    Route::resource('grades', GradeController::class)->names('Academic.grades')->except(['show', 'create', 'edit']);
                    Route::prefix('grades')->name('Academic.grades.')->group(function () {
                        Route::get('archive', [GradeController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [GradeController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [GradeController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Classrooms ───────────────────────────────────────────────────────────────
                    Route::resource('classrooms', ClassroomController::class)->names('Academic.classrooms')->except(['show', 'create', 'edit']);
                    Route::prefix('classrooms')->name('Academic.classrooms.')->group(function () {
                        Route::get('archive', [ClassroomController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [ClassroomController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [ClassroomController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('/by-grade', [ClassroomController::class, 'getByGrade'])->name('by-grade');
                    });

                    // ─── Sections ───────────────────────────────────────────────────────────────
                    Route::resource('sections', SectionController::class)->names('Academic.sections')->except(['show', 'create', 'edit']);
                    Route::prefix('sections/')->name('Academic.sections.')->group(function () {
                        Route::get('archive', [SectionController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [SectionController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [SectionController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('by-classroom', [SectionController::class, 'getByClassroom'])->name('by-classroom');
                        Route::get('{section}/students', [SectionController::class, 'studentsOf'])->name('students');
                    });

                    // ─── Guardians ───────────────────────────────────────────────────────────────
                    Route::resource('guardians', GuardianController::class)->names('Users.guardians')->except(['show', 'create', 'edit']);
                    Route::prefix('guardians/')->name('Users.guardians.')->group(function () {
                        Route::get('archive', [GuardianController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [GuardianController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [GuardianController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Students ───────────────────────────────────────────────────────────────
                    Route::resource('students', StudentController::class)->names('Users.students')->except(['show', 'create']);
                    Route::prefix('students/')->name('Users.students.')->group(function () {

                        // ─── Promotion  ─────────────────────────────────────────────────────────
                        Route::prefix('promotions')->name('promotions.')->group(function () {
                            Route::get('/', [StudentPromotionController::class, 'index'])->name('index');
                            Route::post('/', [StudentPromotionController::class, 'store'])->name('store');
                            Route::get('history', [PromotionHistoryController::class, 'index'])->name('history');
                            Route::post('rollback/{id}', [PromotionHistoryController::class, 'rollback'])->name('rollback');
                        });

                        Route::get('archive', [StudentController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [StudentController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [StudentController::class, 'forceDelete'])->name('forceDelete');
                        Route::get('/next-code', [StudentController::class, 'getNextStudentCode'])->name('next-code');
                        Route::post('attachments/destroy', [StudentController::class, 'deleteAttachment'])->name('attachment.destroy');
                        Route::get('search', [StudentController::class, 'search'])->name('search');
                        Route::get('{student}/finance', [StudentController::class, 'finance'])->name('finance');
                        Route::get('{student}/grades', [StudentController::class, 'grades'])->name('grades');
                    });

                    // ─── Graduations (Alumni Archive) ───────────────────────────────────────────────
                    Route::prefix('graduations')->name('Students.graduations.')->group(function () {
                        Route::get('/', [GraduationController::class, 'index'])->name('index');
                        Route::post('restore/{id}', [GraduationController::class, 'restore'])->name('restore');
                    });

                    // ─── Teachers ───────────────────────────────────────────────────────────────
                    Route::resource('teachers', TeacherController::class)->names('Users.teachers')->except(['show', 'create', 'edit']);
                    Route::prefix('teachers/')->name('Users.teachers.')->group(function () {
                        Route::delete('attachments/{id}', [TeacherController::class, 'deleteAttachment'])->name('attachments.destroy');
                        Route::get('archive', [TeacherController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [TeacherController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [TeacherController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── HR Employees ─────────────────────────────────────────────────────────────
                    Route::resource('employees', EmployeeController::class)->names('Users.employees')->except(['show', 'create', 'edit']);
                    Route::prefix('employees/')->name('Users.employees.')->group(function () {
                        Route::delete('attachments/{id}', [EmployeeController::class, 'deleteAttachment'])->name('attachments.destroy');
                        Route::get('archive', [EmployeeController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [EmployeeController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [EmployeeController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Teacher Assignments ───────────────────────────────────────────────────────────────
                    Route::resource('teacher_assignments', TeacherAssignmentController::class)->names('LMS.teacher_assignments')->except(['show', 'create']);

                    // ─── Finance (Fees & Fee Categories) ─────────────────────────────────────────────────
                    Route::prefix('fee_categories')->name('Finance.fee_categories.')->group(function () {
                        Route::get('/datatable', [FeeCategoryController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('fee_categories', FeeCategoryController::class)->names('Finance.fee_categories')->except(['show', 'create', 'edit']);

                    Route::prefix('fees')->name('Finance.fees.')->group(function () {
                        Route::get('/datatable', [FeeController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('fees', FeeController::class)->names('Finance.fees')->except(['show', 'create', 'edit']);

                    // ─── Invoices ───────────────────────────────────────────────────────────────
                    Route::prefix('invoices')->name('Finance.invoices.')->group(function () {
                        Route::get('/datatable', [InvoiceController::class, 'datatable'])->name('datatable');
                        Route::get('/{invoice}/print', [InvoiceController::class, 'print'])->name('print');
                    });
                    Route::resource('invoices', InvoiceController::class)->names('Finance.invoices')->except(['show', 'create', 'edit']);

                    // ─── Receipts ───────────────────────────────────────────────────────────────
                    Route::prefix('receipts')->name('Finance.receipts.')->group(function () {
                        Route::get('/datatable', [ReceiptController::class, 'datatable'])->name('datatable');
                        Route::get('/{receipt}/print', [ReceiptController::class, 'print'])->name('print');
                    });
                    Route::resource('receipts', ReceiptController::class)->names('Finance.receipts')->except(['show', 'create', 'edit']);

                    // ─── Payment Vouchers ──────────────────────────────────────────────────────────
                    Route::prefix('payment_vouchers')->name('Finance.payment_vouchers.')->group(function () {
                        Route::get('/datatable', [PaymentVoucherController::class, 'datatable'])->name('datatable');
                        Route::get('/{payment_voucher}/print', [PaymentVoucherController::class, 'print'])->name('print');
                    });
                    Route::resource('payment_vouchers', PaymentVoucherController::class)->names('Finance.payment_vouchers')->except(['show', 'create', 'edit']);

                    // ─── Student Discounts ─────────────────────────────────────────────────────────
                    Route::prefix('student_discounts')->name('Finance.student_discounts.')->group(function () {
                        Route::get('/datatable', [StudentDiscountController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('student_discounts', StudentDiscountController::class)->names('Finance.student_discounts')->except(['show', 'create', 'edit']);

                    // ─── Currencies ─────────────────────────────────────────────────────────────────
                    Route::prefix('currencies')->name('Finance.currencies.')->group(function () {
                        Route::get('/datatable', [CurrencyController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('currencies', CurrencyController::class)->names('Finance.currencies')->except(['show', 'create', 'edit']);

                    // ─── Payment Gateways ──────────────────────────────────────────────────────────
                    Route::prefix('payment_gateways')->name('Finance.payment_gateways.')->group(function () {
                        Route::get('/settings-schema', [PaymentGatewayController::class, 'settingsSchema'])->name('settings-schema');
                        Route::post('/activate', [PaymentGatewayController::class, 'activate'])->name('activate');
                        Route::patch('/{payment_gateway}/toggle-status', [PaymentGatewayController::class, 'toggleStatus'])->name('toggle-status');
                    });
                    Route::resource('payment_gateways', PaymentGatewayController::class)->only(['index', 'update'])->names('Finance.payment_gateways');

                    // ─── Reports ───────────────────────────────────────────────────────────────
                    Route::prefix('reports')->name('Reports.reports.')->group(function () {
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
                    Route::resource('specializations', SpecializationController::class)->names('HR.specializations')->except(['show', 'create', 'edit']);

                    // ─── Departments ───────────────────────────────────────────────────────────────
                    Route::resource('departments', DepartmentController::class)->names('HR.departments')->except(['show', 'create', 'edit']);

                    // ─── Designations ───────────────────────────────────────────────────────────────
                    Route::resource('designations', DesignationController::class)->names('HR.designations')->except(['show', 'create', 'edit']);

                    // ─── Profile ───────────────────────────────────────────────────────────────
                    Route::prefix('profile')->name('profile.')->group(function () {
                        Route::get('/', [ProfileController::class, 'index'])->name('index');
                        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('update');
                        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
                        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar');
                    });

                    // ─── Subject ───────────────────────────────────────────────────────────────
                    Route::resource('subjects', SubjectController::class)->names('Academic.subjects')->except(['show', 'create', 'edit']);
                    Route::prefix('subjects/')->name('Academic.subjects.')->group(function () {
                        Route::get('archive', [SubjectController::class, 'archive'])->name('archived');
                        Route::post('restore/{id}', [SubjectController::class, 'restore'])->name('restore');
                        Route::delete('force-delete/{id}', [SubjectController::class, 'forceDelete'])->name('forceDelete');
                    });

                    // ─── Attendance ───────────────────────────────────────────────────────────────
                    Route::prefix('attendances')->name('HR.attendances.')->group(function () {
                        Route::get('/', [AttendanceController::class, 'index'])->name('index');
                        Route::get('/students', [AttendanceController::class, 'getStudents'])->name('students');
                        Route::post('/', [AttendanceController::class, 'store'])->name('store');
                        Route::post('/print-section', [AttendanceController::class, 'printSectionAttendance'])->name('print-section');
                    });

                    // ─── Exams ───────────────────────────────────────────────────────────────
                    Route::prefix('exams')->name('Exams.exams.')->group(function () {
                        Route::get('/', [ExamController::class, 'index'])->name('index');
                        Route::get('/datatable', [ExamController::class, 'datatable'])->name('datatable');
                        Route::get('/{exam}/attempts', [ExamController::class, 'showAttempts'])->name('attempts');
                        Route::post('/{exam}/reset-attempt', [ExamController::class, 'resetAttempt'])->name('resetAttempt');
                    });

                    // ─── Online Classes ───────────────────────────────────────────────────────────────
                    Route::prefix('online_classes')->name('LMS.online_classes.')->group(function () {
                        Route::get('/datatable', [OnlineClassController::class, 'datatable'])->name('datatable');
                    });
                    Route::resource('online_classes', OnlineClassController::class)->names('LMS.online_classes')->except(['create', 'edit']);

                    // ─── Library (Books) ───────────────────────────────────────────────────────────────
                    Route::prefix('library')->name('library.')->group(function () {
                        Route::get('/', [BookController::class, 'index'])->name('index');
                        Route::get('/datatable', [BookController::class, 'datatable'])->name('datatable');
                        Route::get('/download/{book}', [BookController::class, 'download'])->name('download');
                        Route::delete('/destroy/{book}', [BookController::class, 'destroy'])->name('destroy');
                    });

                    // ─── Helper Routes for Dependent Dropdowns ──────────────────────────────────────────
                    Route::get('get-classrooms', [ClassroomController::class, 'getByGrade'])->name('Academic.classrooms.get_classrooms');
                    Route::get('get-sections', [SectionController::class, 'getByClassroom'])->name('Academic.sections.get_sections');
                    Route::get('get-sections-by-grade', [SectionController::class, 'getByGrade'])->name('Academic.sections.get_sections_by_grade');
                    Route::get('get-designations', [DesignationController::class, 'getByDepartment'])->name('HR.designations.get_designations');

                    // ─── Academic Year ───────────────────────────────────────────────────────────────
                    Route::resource('academic_years', AcademicYearController::class)->names('Academic.academic_years')->except(['show', 'create', 'edit', 'destroy']);

                    // ─── Notifications ───────────────────────────────────────────────────────────────
                    Route::prefix('notifications')->name('System.notifications.')->group(function () {
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
                    Route::prefix('activity_logs')->name('System.activity_logs.')->group(function () {
                        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
                        Route::get('/datatable', [ActivityLogController::class, 'datatable'])->name('datatable');
                        Route::get('/subject/logs', [ActivityLogController::class, 'forSubject'])->name('for-subject');
                        Route::get('/causer/logs', [ActivityLogController::class, 'byCauser'])->name('by-causer');
                        Route::get('/statistics/summary', [ActivityLogController::class, 'statistics'])->name('statistics');
                        Route::post('/cleanup', [ActivityLogController::class, 'cleanup'])->name('cleanup');
                        Route::get('/{id}', [ActivityLogController::class, 'show'])->name('show')->where('id', '[0-9]+');
                    });

                    // ─── Settings ───────────────────────────────────────────────────────────────
                    Route::prefix('settings')->name('settings.')->group(function () {
                        // General Settings
                        Route::prefix('general')->name('general.')->group(function () {
                            Route::get('/', [GeneralSettingController::class, 'index'])->name('index');
                            Route::put('/', [GeneralSettingController::class, 'update'])->name('update');
                        });

                        // Days of Week
                        Route::prefix('days_of_week')->name('days_of_week.')->group(function () {
                            Route::get('/', [DayOfWeekController::class, 'index'])->name('index');
                            Route::put('/{dayOfWeek}', [DayOfWeekController::class, 'update'])->name('update');
                            Route::post('/toggle-all', [DayOfWeekController::class, 'toggleAll'])->name('toggle_all');
                        });

                        // External API Settings
                        Route::prefix('external-api')->name('external-api.')->group(function () {
                            Route::get('/', [ExternalApiSettingController::class, 'index'])->name('index');
                            Route::put('/{external_api_setting}', [ExternalApiSettingController::class, 'update'])->name('update');
                            Route::post('/{external_api_setting}/toggle-status', [ExternalApiSettingController::class, 'toggleStatus'])->name('toggle_status');
                        });
                    });

                    // ─── Schedule ───────────────────────────────────────────────────────────────
                    Route::prefix('schedule')->name('schedule.')->group(function () {
                        // Class Periods
                        Route::prefix('class_periods')->name('class_periods.')->group(function () {
                            Route::get('/', [ClassPeriodController::class, 'index'])->name('index');
                            Route::get('/datatable', [ClassPeriodController::class, 'datatable'])->name('datatable');
                            Route::post('/', [ClassPeriodController::class, 'store'])->name('store');
                            Route::put('/{classPeriod}', [ClassPeriodController::class, 'update'])->name('update');
                            Route::delete('/{classPeriod}', [ClassPeriodController::class, 'destroy'])->name('destroy');
                        });

                        // Timetables
                        Route::prefix('timetables')->name('timetables.')->group(function () {
                            Route::get('/', [TimetableController::class, 'index'])->name('index');
                            Route::get('/matrix', [TimetableController::class, 'matrix'])->name('matrix');
                            Route::get('/subjects', [TimetableController::class, 'getSubjects'])->name('getSubjects');
                            Route::get('/teachers', [TimetableController::class, 'getTeachers'])->name('getTeachers');
                            Route::post('/', [TimetableController::class, 'store'])->name('store');
                            Route::put('/{timetable}', [TimetableController::class, 'update'])->name('update');
                            Route::delete('/{timetable}', [TimetableController::class, 'destroy'])->name('destroy');
                        });
                    });

                    // ─── CMS (Website Management) ───────────────────────────────────────────────
                    Route::prefix('cms')->name('CMS.cms.')->group(function () {
                        Route::get('/', [CmsController::class, 'index'])->name('index');
                        Route::post('/reorder', [CmsController::class, 'reorder'])->name('reorder');
                        Route::get('/sections/{section}/edit', [CmsController::class, 'editSection'])->name('sections.edit');
                        Route::put('/sections/{section}', [CmsController::class, 'updateSection'])->name('sections.update');
                        Route::patch('/sections/{section}/toggle', [CmsController::class, 'toggleVisibility'])->name('sections.toggle');
                        Route::get('/legal', [CmsController::class, 'legalPages'])->name('legal.index');
                        Route::get('/legal/{page}/edit', [CmsController::class, 'editLegalPage'])->name('legal.edit');
                        Route::put('/legal/{page}', [CmsController::class, 'updateLegalPage'])->name('legal.update');
                    });
                });
                Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
            });
        });
    }
);
