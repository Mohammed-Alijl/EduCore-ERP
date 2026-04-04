@extends('admin.layouts.master')

@section('title', trans('admin.sidebar.dashboard'))

@section('css')
    <link href="{{ URL::asset('assets/admin/css/Dashboard/dashboard.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    {{-- ── Breadcrumb / Welcome ──────────────────────────────────────────────── --}}
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content dashboard-welcome">
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">
                {{ trans('admin.dashboard.welcome') . ' ' . auth('admin')->user()->name }}
            </h2>
            <p class="mg-b-0">{{ trans('admin.dashboard.subtitle') }}</p>
        </div>
        <div class="main-dashboard-header-right">
            @if ($academicYear)
                <div class="dashboard-date-badge mr-3 ml-3">
                    <i class="fas fa-graduation-cap"></i>
                    {{ trans('admin.dashboard.academic_year') }}: {{ $academicYear->name }}
                </div>
            @endif
            <div class="dashboard-date-badge">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}
            </div>
        </div>
    </div>
@endsection

@section('content')

    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 1 — Stat Cards (Enhanced with Sparklines & 3D Effects)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">

        {{-- Students --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
            <div class="card dashboard-stat-card bg-gradient-primary" x-data="statCardTilt()">
                <div class="dashboard-stat-card-inner">
                    <div class="dashboard-stat-card-shine"></div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div style="flex: 1;">
                            <p class="stat-label mb-1">{{ trans('admin.dashboard.total_students') }}</p>
                            <h3 class="stat-value">{{ number_format($statCards['students']['total']) }}</h3>
                            <span class="stat-growth {{ $statCards['students']['growth'] >= 0 ? 'positive' : 'negative' }}">
                                <i class="fas fa-arrow-{{ $statCards['students']['growth'] >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($statCards['students']['growth']) }}%
                                <small class="ml-1">{{ trans('admin.dashboard.vs_last_month') }}</small>
                            </span>
                            {{-- Growth Progress Bar --}}
                            <div class="stat-growth-bar">
                                <div class="stat-growth-bar-fill"
                                    style="width: {{ min(abs($statCards['students']['growth']), 100) }}%"></div>
                            </div>
                            {{-- Sparkline Placeholder --}}
                            <div class="stat-sparkline" id="sparkline-students"></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                    {{-- Quick Action Button --}}
                    <a href="#" class="stat-quick-action">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Teachers --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
            <div class="card dashboard-stat-card bg-gradient-success" x-data="statCardTilt()">
                <div class="dashboard-stat-card-inner">
                    <div class="dashboard-stat-card-shine"></div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div style="flex: 1;">
                            <p class="stat-label mb-1">{{ trans('admin.dashboard.total_teachers') }}</p>
                            <h3 class="stat-value">{{ number_format($statCards['teachers']['total']) }}</h3>
                            <span
                                class="stat-growth {{ $statCards['teachers']['growth'] >= 0 ? 'positive' : 'negative' }}">
                                <i class="fas fa-arrow-{{ $statCards['teachers']['growth'] >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($statCards['teachers']['growth']) }}%
                                <small class="ml-1">{{ trans('admin.dashboard.vs_last_month') }}</small>
                            </span>
                            {{-- Growth Progress Bar --}}
                            <div class="stat-growth-bar">
                                <div class="stat-growth-bar-fill"
                                    style="width: {{ min(abs($statCards['teachers']['growth']), 100) }}%"></div>
                            </div>
                            {{-- Sparkline Placeholder --}}
                            <div class="stat-sparkline" id="sparkline-teachers"></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                    {{-- Quick Action Button --}}
                    <a href="#" class="stat-quick-action">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
            <div class="card dashboard-stat-card bg-gradient-info" x-data="statCardTilt()">
                <div class="dashboard-stat-card-inner">
                    <div class="dashboard-stat-card-shine"></div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div style="flex: 1;">
                            <p class="stat-label mb-1">{{ trans('admin.dashboard.total_revenue') }}</p>
                            <h3 class="stat-value">${{ number_format($statCards['revenue']['total'], 0) }}</h3>
                            <span class="stat-growth {{ $statCards['revenue']['growth'] >= 0 ? 'positive' : 'negative' }}">
                                <i class="fas fa-arrow-{{ $statCards['revenue']['growth'] >= 0 ? 'up' : 'down' }}"></i>
                                {{ abs($statCards['revenue']['growth']) }}%
                                <small class="ml-1">{{ trans('admin.dashboard.this_month') }}</small>
                            </span>
                            {{-- Growth Progress Bar --}}
                            <div class="stat-growth-bar">
                                <div class="stat-growth-bar-fill"
                                    style="width: {{ min(abs($statCards['revenue']['growth']), 100) }}%"></div>
                            </div>
                            {{-- Sparkline Placeholder --}}
                            <div class="stat-sparkline" id="sparkline-revenue"></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    {{-- Quick Action Button --}}
                    <a href="#" class="stat-quick-action">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Attendance Rate --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-3">
            <div class="card dashboard-stat-card bg-gradient-warning" x-data="statCardTilt()">
                <div class="dashboard-stat-card-inner">
                    <div class="dashboard-stat-card-shine"></div>
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div style="flex: 1;">
                            <p class="stat-label mb-1">{{ trans('admin.dashboard.attendance_rate') }}</p>
                            <h3 class="stat-value">{{ $statCards['attendance']['rate'] }}%</h3>
                            <span class="stat-growth neutral">
                                {{ $statCards['attendance']['present'] }}/{{ $statCards['attendance']['total'] }}
                                <small class="ml-1">{{ trans('admin.dashboard.present_today') }}</small>
                            </span>
                            {{-- Growth Progress Bar --}}
                            <div class="stat-growth-bar">
                                <div class="stat-growth-bar-fill" style="width: {{ $statCards['attendance']['rate'] }}%">
                                </div>
                            </div>
                            {{-- Sparkline Placeholder --}}
                            <div class="stat-sparkline" id="sparkline-attendance"></div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                    {{-- Quick Action Button --}}
                    <a href="#" class="stat-quick-action">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 2 — Enrollment Trend + Attendance Donut (Enhanced with Controls)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">

        {{-- Enrollment Trend --}}
        <div class="col-xl-7 col-lg-12 mb-3">
            <div class="card dashboard-chart-card" x-data="{ refreshing: false }">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.monthly_enrollment') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.enrollment_subtitle') }}</p>
                    </div>
                    <button @click="refreshing = true; setTimeout(() => refreshing = false, 1500)"
                        class="chart-refresh-btn" :class="{ 'refreshing': refreshing }">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="chart-enrollment-trend"></div>
                </div>
            </div>
        </div>

        {{-- Attendance Donut --}}
        <div class="col-xl-5 col-lg-12 mb-3">
            <div class="card dashboard-chart-card" x-data="{ refreshing: false }">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.attendance_overview') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.attendance_subtitle') }}</p>
                    </div>
                    <button @click="refreshing = true; setTimeout(() => refreshing = false, 1500)"
                        class="chart-refresh-btn" :class="{ 'refreshing': refreshing }">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="chart-attendance-donut"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 3 — Revenue vs Invoices + Students per Grade (Enhanced with Controls)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">

        {{-- Revenue vs Invoices --}}
        <div class="col-xl-7 col-lg-12 mb-3">
            <div class="card dashboard-chart-card" x-data="{ refreshing: false }">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.revenue_vs_invoices') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.revenue_subtitle') }}</p>
                    </div>
                    <button @click="refreshing = true; setTimeout(() => refreshing = false, 1500)"
                        class="chart-refresh-btn" :class="{ 'refreshing': refreshing }">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="chart-revenue-trend"></div>
                </div>
            </div>
        </div>

        {{-- Students per Grade --}}
        <div class="col-xl-5 col-lg-12 mb-3">
            <div class="card dashboard-chart-card" x-data="{ refreshing: false }">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.students_per_grade') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.grade_subtitle') }}</p>
                    </div>
                    <button @click="refreshing = true; setTimeout(() => refreshing = false, 1500)"
                        class="chart-refresh-btn" :class="{ 'refreshing': refreshing }">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div id="chart-students-grade"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 4 — Recent Invoices Table + Quick Stats (Enhanced with Actions)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">
        {{-- Recent Invoices --}}
        <div class="col-xl-7 col-lg-12 mb-3">
            <div class="card dashboard-table-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.recent_invoices') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.invoices_subtitle') }}</p>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($recentInvoices->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ trans('admin.dashboard.student_name') }}</th>
                                        <th>{{ trans('admin.dashboard.fee_type') }}</th>
                                        <th class="text-right">{{ trans('admin.dashboard.amount') }}</th>
                                        <th>{{ trans('admin.dashboard.date') }}</th>
                                        <th class="text-center" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentInvoices as $invoice)
                                        <tr class="table-row-actions" x-data="{ showActions: false }"
                                            @mouseenter="showActions = true" @mouseleave="showActions = false">
                                            <td>{{ $invoice->student?->name ?? '—' }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-soft-primary">{{ $invoice->fee?->title ?? '—' }}</span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                ${{ number_format($invoice->amount, 2) }}
                                            </td>
                                            <td>{{ $invoice->invoice_date?->format('d M Y') ?? '—' }}</td>
                                            <td class="text-center">
                                                <div class="table-actions" x-show="showActions" x-transition>
                                                    <a href="#" class="table-action-btn table-action-view"
                                                        title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" class="table-action-btn table-action-edit"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <i class="fas fa-file-invoice"></i>
                            <p>{{ trans('admin.dashboard.no_invoices') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Stats (Enhanced with Radial Progress) --}}
        <div class="col-xl-5 col-lg-12 mb-3">
            <div class="card dashboard-chart-card mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-1">{{ trans('admin.dashboard.quick_stats') }}</h4>
                </div>
                <div class="card-body">
                    <div class="quick-stats-grid">
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="75, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['subjects']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.subjects') }}</div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="60, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['classrooms']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.classrooms') }}</div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="85, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['guardians']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.guardians') }}</div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="70, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['exams']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.exams') }}</div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="55, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-book-open"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['books']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.books') }}</div>
                        </div>
                        <div class="quick-stat-item">
                            <div class="quick-stat-icon-wrapper">
                                <svg class="quick-stat-progress" viewBox="0 0 36 36">
                                    <path class="quick-stat-progress-bg"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="quick-stat-progress-fill" stroke-dasharray="65, 100"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <i class="fas fa-id-badge"></i>
                            </div>
                            <div class="stat-number">{{ number_format($quickStats['employees']) }}</div>
                            <div class="stat-text">{{ trans('admin.dashboard.employees') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 5 — Upcoming Classes + Performance Gauges (Enhanced)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row">
        {{-- Upcoming Online Classes --}}
        <div class="col-xl-7 col-lg-12 mb-3">
            <div class="card dashboard-chart-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.upcoming_classes') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.classes_subtitle') }}</p>
                    </div>
                </div>
                <div class="card-body">
                    @if ($upcomingClasses->isNotEmpty())
                        @foreach ($upcomingClasses as $class)
                            <div class="upcoming-class-item">
                                {{-- Teacher Avatar --}}
                                <div class="upcoming-class-avatar">
                                    @php
                                        $teacherName = $class->teacher?->name ?? 'Unknown';
                                        $initials = collect(explode(' ', $teacherName))
                                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                            ->take(2)
                                            ->join('');
                                    @endphp
                                    <span class="avatar-text">{{ $initials }}</span>
                                </div>
                                <div class="upcoming-class-icon">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div class="upcoming-class-info">
                                    <h6>{{ $class->topic }}</h6>
                                    <span>
                                        {{ $class->teacher?->name ?? '—' }}
                                        · {{ $class->subject?->name ?? '' }}
                                    </span>
                                </div>
                                <div class="upcoming-class-time">
                                    <i class="far fa-clock"></i>
                                    {{ $class->start_at?->format('h:i A') }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="dashboard-empty-state">
                            <i class="fas fa-video-slash"></i>
                            <p>{{ trans('admin.dashboard.no_classes') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Performance Gauges (Enhanced with Tier Badges) --}}
        <div class="col-xl-5 col-lg-12 mb-3">
            <div class="card dashboard-chart-card dashboard-gauges-card">
                <div class="card-header">
                    <h4 class="card-title mb-1">{{ trans('admin.dashboard.performance_metrics') }}</h4>
                    <p class="card-subtitle mb-0">{{ trans('admin.dashboard.performance_subtitle') }}</p>
                </div>
                <div class="card-body">
                    <div class="gauges-grid">
                        @foreach ($performanceGauges as $key => $gauge)
                            <div class="gauge-item">
                                <div class="gauge-circle gauge-{{ $gauge['color'] }}"
                                    data-value="{{ $gauge['value'] }}">
                                    <svg viewBox="0 0 36 36">
                                        <path class="gauge-bg"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        <path class="gauge-fill" stroke-dasharray="{{ $gauge['value'] }}, 100"
                                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    </svg>
                                    <div class="gauge-value">{{ $gauge['value'] }}%</div>
                                </div>
                                <div class="gauge-label">{{ trans('admin.dashboard.' . $gauge['label']) }}</div>
                                {{-- Performance Tier Badge --}}
                                @php
                                    $tier =
                                        $gauge['value'] >= 80
                                            ? 'excellent'
                                            : ($gauge['value'] >= 60
                                                ? 'good'
                                                : 'improve');
                                    $tierLabel =
                                        $tier === 'excellent'
                                            ? 'Excellent'
                                            : ($tier === 'good'
                                                ? 'Good'
                                                : 'Needs Work');
                                @endphp
                                <span class="gauge-tier-badge gauge-tier-{{ $tier }}">{{ $tierLabel }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════════
         ROW 6 — Recent Activity Timeline (Enhanced with Avatars)
         ══════════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">

        {{-- Recent Activity Timeline --}}
        <div class="col-xl-12 col-lg-12 mb-3">
            <div class="card dashboard-chart-card dashboard-activity-card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="card-title mb-1">{{ trans('admin.dashboard.recent_activity') }}</h4>
                        <p class="card-subtitle mb-0">{{ trans('admin.dashboard.activity_subtitle') }}</p>
                    </div>
                    <div class="activity-filter-btns" x-data="{ filter: 'all' }">
                        <button @click="filter = 'all'" :class="{ 'active': filter === 'all' }"
                            class="activity-filter-btn">All</button>
                        <button @click="filter = 'student'" :class="{ 'active': filter === 'student' }"
                            class="activity-filter-btn">Students</button>
                        <button @click="filter = 'invoice'" :class="{ 'active': filter === 'invoice' }"
                            class="activity-filter-btn">Invoices</button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($recentActivity->isNotEmpty())
                        <div class="activity-timeline">
                            @foreach ($recentActivity as $activity)
                                <div class="activity-item" data-type="{{ $activity['type'] }}">
                                    {{-- Avatar with Initials --}}
                                    <div class="activity-avatar activity-avatar-{{ $activity['color'] }}">
                                        @php
                                            $name = $activity['title'] ?? 'Unknown';
                                            $initials = collect(explode(' ', $name))
                                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                                ->take(2)
                                                ->join('');
                                        @endphp
                                        <span class="avatar-text">{{ $initials }}</span>
                                    </div>
                                    <div class="activity-icon activity-{{ $activity['color'] }}">
                                        <i class="fas {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-header">
                                            <span class="activity-title">{{ $activity['title'] }}</span>
                                            @if (isset($activity['amount']))
                                                <span
                                                    class="activity-amount">${{ number_format($activity['amount'], 2) }}</span>
                                            @endif
                                        </div>
                                        <p class="activity-action">{{ trans('admin.dashboard.' . $activity['action']) }}
                                        </p>
                                        <span class="activity-time">
                                            <i class="far fa-clock"></i>
                                            {{ $activity['time']?->diffForHumans() ?? '—' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="dashboard-empty-state">
                            <i class="fas fa-history"></i>
                            <p>{{ trans('admin.dashboard.no_activity') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    {{-- ApexCharts --}}
    <script src="{{ URL::asset('assets/admin/js/apexcharts.js') }}"></script>

    {{-- Pass data from PHP to JS --}}
    <script>
        var enrollmentTrendData = @json($enrollmentTrend);
        var revenueTrendData = @json($revenueTrend);
        var attendanceDonutData = @json($attendanceDonut);
        var studentsPerGradeData = @json($studentsPerGrade);
        var dashboardLabels = {
            newStudents: @json(trans('admin.dashboard.new_students')),
            collected: @json(trans('admin.dashboard.collected')),
            invoiced: @json(trans('admin.dashboard.invoiced')),
            present: @json(trans('admin.dashboard.present')),
            absent: @json(trans('admin.dashboard.absent')),
            late: @json(trans('admin.dashboard.late')),
            totalRecords: @json(trans('admin.dashboard.total_records')),
            noData: @json(trans('admin.dashboard.no_data')),
            students: @json(trans('admin.dashboard.students')),
        };
    </script>

    {{-- Dashboard Charts --}}
    <script src="{{ URL::asset('assets/admin/js/dashboard/dashboard.js') }}"></script>
@endsection
