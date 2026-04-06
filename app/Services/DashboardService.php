<?php

namespace App\Services;

use App\Models\Academic\AcademicYear;
use App\Models\Attendance\Attendance;
use App\Models\Academic\Book;
use App\Models\Academic\ClassRoom;
use App\Models\Users\Employee;
use App\Models\Assessments\Exam;
use App\Models\Academic\Grade;
use App\Models\Users\Guardian;
use App\Models\Finance\Invoice;
use App\Models\Scheduling\OnlineClass;
use App\Models\Finance\Receipt;
use App\Models\Users\Student;
use App\Models\Academic\Subject;
use App\Models\Users\Teacher;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Gather all dashboard KPIs in a single method.
     *
     * @return array<string, mixed>
     */
    public function getKpis(): array
    {
        $currentAcademicYear = AcademicYear::where('is_current', true)->first();

        return [
            'statCards' => $this->getStatCards($currentAcademicYear),
            'enrollmentTrend' => $this->getMonthlyEnrollmentTrend(),
            'revenueTrend' => $this->getMonthlyRevenueTrend($currentAcademicYear),
            'attendanceDonut' => $this->getAttendanceDistribution($currentAcademicYear),
            'studentsPerGrade' => $this->getStudentsPerGrade(),
            'recentInvoices' => $this->getRecentInvoices(),
            'upcomingClasses' => $this->getUpcomingOnlineClasses(),
            'quickStats' => $this->getQuickStats(),
            'academicYear' => $currentAcademicYear,
            'performanceGauges' => $this->getPerformanceGauges($currentAcademicYear),
            'recentActivity' => $this->getRecentActivity(),
        ];
    }

    // ─── Stat Cards ──────────────────────────────────────────────────────────

    /**
     * @return array<string, array<string, mixed>>
     */
    private function getStatCards(?AcademicYear $academicYear): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfPrevMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfPrevMonth = $now->copy()->subMonth()->endOfMonth();

        // ── Students ─────────────────────────────────────────────────────────
        $totalStudents = Student::active()->count();
        $studentsThisMonth = Student::active()
            ->where('created_at', '>=', $startOfMonth)
            ->count();
        $studentsPrevMonth = Student::active()
            ->whereBetween('created_at', [$startOfPrevMonth, $endOfPrevMonth])
            ->count();

        // ── Teachers ─────────────────────────────────────────────────────────
        $totalTeachers = Teacher::active()->count();
        $teachersThisMonth = Teacher::active()
            ->where('created_at', '>=', $startOfMonth)
            ->count();
        $teachersPrevMonth = Teacher::active()
            ->whereBetween('created_at', [$startOfPrevMonth, $endOfPrevMonth])
            ->count();

        // ── Revenue ──────────────────────────────────────────────────────────
        $revenueQuery = Receipt::query();
        if ($academicYear) {
            $revenueQuery->where('academic_year_id', $academicYear->id);
        }
        $totalRevenue = (float) $revenueQuery->sum('base_amount');

        $revenueThisMonth = Receipt::query()
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->where('date', '>=', $startOfMonth)
            ->sum('base_amount');
        $revenuePrevMonth = Receipt::query()
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->whereBetween('date', [$startOfPrevMonth, $endOfPrevMonth])
            ->sum('base_amount');

        // ── Attendance Rate (Today) ──────────────────────────────────────────
        $todayAttendance = Attendance::where('attendance_date', $now->toDateString());
        if ($academicYear) {
            $todayAttendance->where('academic_year_id', $academicYear->id);
        }
        $totalToday = $todayAttendance->count();
        $presentToday = (clone $todayAttendance)
            ->where('attendance_status', Attendance::STATUS_PRESENT)
            ->count();
        $attendanceRate = $totalToday > 0
            ? round(($presentToday / $totalToday) * 100, 1)
            : 0;

        return [
            'students' => [
                'total' => $totalStudents,
                'growth' => $this->calcGrowth($studentsThisMonth, $studentsPrevMonth),
                'current' => $studentsThisMonth,
            ],
            'teachers' => [
                'total' => $totalTeachers,
                'growth' => $this->calcGrowth($teachersThisMonth, $teachersPrevMonth),
                'current' => $teachersThisMonth,
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'growth' => $this->calcGrowth((float) $revenueThisMonth, (float) $revenuePrevMonth),
                'current' => (float) $revenueThisMonth,
            ],
            'attendance' => [
                'rate' => $attendanceRate,
                'present' => $presentToday,
                'total' => $totalToday,
            ],
        ];
    }

    // ─── Charts ──────────────────────────────────────────────────────────────

    /**
     * Monthly student creation count for the past 12 months.
     *
     * @return array{labels: string[], data: int[]}
     */
    private function getMonthlyEnrollmentTrend(): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $enrollments = Student::query()
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($item) => $item->year.'-'.$item->month);

        $labels = [];
        $data = [];
        foreach ($months as $month) {
            $labels[] = $month->translatedFormat('M');
            $key = $month->year.'-'.$month->month;
            $data[] = $enrollments->has($key) ? (int) $enrollments->get($key)->count : 0;
        }

        return compact('labels', 'data');
    }

    /**
     * Monthly revenue (Receipts) vs invoices for the past 12 months.
     *
     * @return array{labels: string[], revenue: float[], invoices: float[]}
     */
    private function getMonthlyRevenueTrend(?AcademicYear $academicYear): array
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $months->push(Carbon::now()->subMonths($i));
        }

        $startDate = Carbon::now()->subMonths(11)->startOfMonth();

        $receipts = Receipt::query()
            ->select(
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(base_amount) as total'),
            )
            ->where('date', '>=', $startDate)
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($item) => $item->year.'-'.$item->month);

        $invoices = Invoice::query()
            ->select(
                DB::raw('YEAR(invoice_date) as year'),
                DB::raw('MONTH(invoice_date) as month'),
                DB::raw('SUM(amount) as total'),
            )
            ->where('invoice_date', '>=', $startDate)
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->groupBy('year', 'month')
            ->get()
            ->keyBy(fn ($item) => $item->year.'-'.$item->month);

        $labels = [];
        $revenueData = [];
        $invoiceData = [];
        foreach ($months as $month) {
            $labels[] = $month->translatedFormat('M');
            $key = $month->year.'-'.$month->month;
            $revenueData[] = $receipts->has($key) ? round((float) $receipts->get($key)->total, 2) : 0;
            $invoiceData[] = $invoices->has($key) ? round((float) $invoices->get($key)->total, 2) : 0;
        }

        return ['labels' => $labels, 'revenue' => $revenueData, 'invoices' => $invoiceData];
    }

    /**
     * Attendance breakdown for the current month.
     *
     * @return array{present: int, absent: int, late: int}
     */
    private function getAttendanceDistribution(?AcademicYear $academicYear): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $query = Attendance::query()
            ->where('attendance_date', '>=', $startOfMonth)
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id));

        return [
            'present' => (clone $query)->where('attendance_status', Attendance::STATUS_PRESENT)->count(),
            'absent' => (clone $query)->where('attendance_status', Attendance::STATUS_ABSENT)->count(),
            'late' => (clone $query)->where('attendance_status', Attendance::STATUS_LATE)->count(),
        ];
    }

    /**
     * Active student count per grade (for horizontal bar chart).
     *
     * @return array{labels: string[], data: int[]}
     */
    private function getStudentsPerGrade(): array
    {
        $grades = Grade::active()
            ->withCount(['students' => fn ($q) => $q->active()])
            ->get();

        $labels = $grades->map(fn ($g) => $g->getTranslation('name', app()->getLocale()))->toArray();
        $data = $grades->pluck('students_count')->toArray();

        return compact('labels', 'data');
    }

    // ─── Tables & Lists ──────────────────────────────────────────────────────

    private function getRecentInvoices(): Collection
    {
        return Invoice::with(['student', 'fee', 'grade'])
            ->latest('invoice_date')
            ->limit(5)
            ->get();
    }

    private function getUpcomingOnlineClasses(): Collection
    {
        return OnlineClass::with(['teacher', 'grade', 'subject'])
            ->where('start_at', '>=', Carbon::now())
            ->orderBy('start_at')
            ->limit(5)
            ->get();
    }

    /**
     * @return array<string, int>
     */
    private function getQuickStats(): array
    {
        return [
            'subjects' => Subject::active()->count(),
            'classrooms' => ClassRoom::count(),
            'guardians' => Guardian::count(),
            'exams' => Exam::count(),
            'books' => Book::count(),
            'employees' => Employee::active()->count(),
        ];
    }

    // ─── Performance Gauges ─────────────────────────────────────────────────

    /**
     * Get performance metrics for radial gauges.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getPerformanceGauges(?AcademicYear $academicYear): array
    {
        // Collection Rate: Receipts / Invoices (as percentage)
        $totalInvoiced = Invoice::query()
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->sum('amount');
        $totalCollected = Receipt::query()
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id))
            ->sum('base_amount');
        $collectionRate = $totalInvoiced > 0 ? min(round(($totalCollected / $totalInvoiced) * 100, 1), 100) : 0;

        // Attendance Goal: Target 90%, show current month's attendance rate
        $startOfMonth = Carbon::now()->startOfMonth();
        $attendanceQuery = Attendance::query()
            ->where('attendance_date', '>=', $startOfMonth)
            ->when($academicYear, fn ($q) => $q->where('academic_year_id', $academicYear->id));
        $totalAttendance = (clone $attendanceQuery)->count();
        $presentCount = (clone $attendanceQuery)->where('attendance_status', Attendance::STATUS_PRESENT)->count();
        $attendanceGoal = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100, 1) : 0;

        // Student Capacity: Active students vs a notional capacity (e.g., 500 or based on classrooms)
        $totalStudents = Student::active()->count();
        $totalClassrooms = ClassRoom::count();
        $estimatedCapacity = max($totalClassrooms * 30, 100); // 30 students per class, minimum 100
        $capacityUsed = min(round(($totalStudents / $estimatedCapacity) * 100, 1), 100);

        // Teacher Workload: Avg subjects per teacher
        $totalTeachers = Teacher::active()->count();
        $totalSubjects = Subject::active()->count();
        $avgWorkload = $totalTeachers > 0 ? round($totalSubjects / $totalTeachers, 1) : 0;
        $workloadPercent = min(round(($avgWorkload / 8) * 100, 1), 100); // Assume 8 subjects is 100% capacity

        return [
            'collection' => [
                'value' => $collectionRate,
                'label' => 'collection_rate',
                'color' => $collectionRate >= 80 ? 'success' : ($collectionRate >= 50 ? 'warning' : 'danger'),
            ],
            'attendance' => [
                'value' => $attendanceGoal,
                'label' => 'attendance_goal',
                'color' => $attendanceGoal >= 90 ? 'success' : ($attendanceGoal >= 70 ? 'warning' : 'danger'),
            ],
            'capacity' => [
                'value' => $capacityUsed,
                'label' => 'capacity_used',
                'color' => $capacityUsed <= 70 ? 'success' : ($capacityUsed <= 90 ? 'warning' : 'danger'),
            ],
            'workload' => [
                'value' => $workloadPercent,
                'label' => 'teacher_workload',
                'color' => $workloadPercent <= 70 ? 'success' : ($workloadPercent <= 90 ? 'warning' : 'danger'),
            ],
        ];
    }

    // ─── Recent Activity ────────────────────────────────────────────────────

    /**
     * Get recent activity items from various models.
     *
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function getRecentActivity(): \Illuminate\Support\Collection
    {
        $activities = collect();

        // Recent students
        $recentStudents = Student::latest()->limit(3)->get();
        foreach ($recentStudents as $student) {
            $activities->push([
                'type' => 'student',
                'icon' => 'fa-user-graduate',
                'color' => 'primary',
                'title' => $student->name,
                'action' => 'student_enrolled',
                'time' => $student->created_at,
            ]);
        }

        // Recent invoices
        $recentInvoiceRecords = Invoice::with('student')->latest('invoice_date')->limit(3)->get();
        foreach ($recentInvoiceRecords as $invoice) {
            $activities->push([
                'type' => 'invoice',
                'icon' => 'fa-file-invoice-dollar',
                'color' => 'info',
                'title' => $invoice->student?->name ?? 'Unknown',
                'action' => 'invoice_created',
                'amount' => $invoice->amount,
                'time' => $invoice->created_at ?? $invoice->invoice_date,
            ]);
        }

        // Recent receipts (payments)
        $recentReceipts = Receipt::with('student')->latest('date')->limit(3)->get();
        foreach ($recentReceipts as $receipt) {
            $activities->push([
                'type' => 'receipt',
                'icon' => 'fa-money-bill-wave',
                'color' => 'success',
                'title' => $receipt->student?->name ?? 'Unknown',
                'action' => 'payment_received',
                'amount' => $receipt->base_amount,
                'time' => $receipt->created_at ?? $receipt->date,
            ]);
        }

        // Recent teachers
        $recentTeachers = Teacher::latest()->limit(2)->get();
        foreach ($recentTeachers as $teacher) {
            $activities->push([
                'type' => 'teacher',
                'icon' => 'fa-chalkboard-teacher',
                'color' => 'warning',
                'title' => $teacher->name,
                'action' => 'teacher_joined',
                'time' => $teacher->created_at,
            ]);
        }

        // Sort by time descending and take top 8
        return $activities->sortByDesc('time')->take(8)->values();
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function calcGrowth(float $current, float $previous): float
    {
        if ($previous <= 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
