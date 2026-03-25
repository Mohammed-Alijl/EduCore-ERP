<!DOCTYPE html>
@php
    $isRtl = $locale === 'ar';
@endphp
<html dir="{{ $isRtl ? 'rtl' : 'ltr' }}" lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.reports.attendance.title', [], $locale) }}</title>

    {{-- Bootstrap 5 (RTL or LTR based on locale) --}}
    @if ($isRtl)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    {{-- Font: Cairo for Arabic, Inter for English --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if ($isRtl)
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    {{-- ApexCharts --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>

    <style>
        * {
            font-family: {{ $isRtl ? "'Cairo'" : "'Inter'" }}, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #1a1a2e;
            padding: 0;
            margin: 0;
        }

        .report-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px 30px;
        }

        /* Header Styles */
        .report-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            color: #ffffff;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .report-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .school-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .school-logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .school-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.9;
        }

        .report-meta {
            text-align: left;
            font-size: 13px;
        }

        .report-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
            opacity: 0.9;
        }

        /* Summary Stats */
        .stats-row {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            flex: 1;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
            text-align: center;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .stat-card.success {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border-color: #a7f3d0;
        }

        .stat-card.success .stat-value {
            color: #047857;
        }

        .stat-card.warning {
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
            border-color: #fde68a;
        }

        .stat-card.warning .stat-value {
            color: #b45309;
        }

        .stat-card.danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-color: #fecaca;
        }

        .stat-card.danger .stat-value {
            color: #dc2626;
        }

        /* Charts Section */
        .charts-section {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .chart-card {
            flex: 1;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
            text-align: center;
        }

        .chart-container {
            width: 100%;
            min-height: 220px;
        }

        /* Table Section */
        .table-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-header {
            background: #f1f5f9;
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .table-subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 5px 0 0 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            padding: 12px 15px;
            text-align: {{ $isRtl ? 'right' : 'left' }};
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }

        .data-table tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        .data-table tbody tr:hover {
            background: #f1f5f9;
        }

        .data-table tbody td {
            padding: 12px 15px;
            color: #334155;
            vertical-align: middle;
        }

        .data-table tbody td.text-center {
            text-align: center;
        }

        /* Percentage Badges */
        .badge-percentage {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 65px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
        }

        .badge-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
        }

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
        }

        /* Row Number */
        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            background: #e2e8f0;
            color: #475569;
            border-radius: 50%;
            font-size: 12px;
            font-weight: 600;
        }

        /* Student Name Style */
        .student-name {
            font-weight: 500;
            color: #1e293b;
        }

        /* Footer */
        .report-footer {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #94a3b8;
        }

        .footer-note {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Print optimizations */
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .report-header {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .data-table tbody tr:nth-child(even) {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .badge-percentage {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .charts-section {
                page-break-inside: avoid;
            }
        }

        /* Page break handling */
        .data-table thead {
            display: table-header-group;
        }

        .data-table tbody tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="report-container">
        {{-- Report Header --}}
        <div class="report-header">
            <div class="header-content">
                <div class="school-info">
                    <div class="school-logo">
                        {{ mb_substr(config('app.name'), 0, 1) }}
                    </div>
                    <div>
                        <div class="school-name">{{ config('app.name') }}</div>
                        <div class="report-title">{{ trans('admin.reports.attendance.title', [], $locale) }}</div>
                    </div>
                </div>
                <div class="report-meta">
                    <div class="report-meta-item">
                        <span>{{ trans('admin.exports.attendance_report.generated_on', [], $locale) }}:</span>
                        <strong>{{ $generatedAt->format('Y-m-d H:i') }}</strong>
                    </div>
                    <div class="report-meta-item">
                        <span>{{ trans('admin.reports.attendance.table.records', [], $locale) }}:</span>
                        <strong>{{ $records->count() }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Statistics --}}
        @php
            $totalRecords = $records->count();
            $avgAttendance = $totalRecords > 0 ? round($records->avg('attendance_percentage'), 2) : 0;
            $atRiskCount = $records->where('attendance_percentage', '<', 85)->count();
            $excellentCount = $records->where('attendance_percentage', '>=', 95)->count();
        @endphp

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($totalRecords) }}</div>
                <div class="stat-label">{{ trans('admin.reports.attendance.table.records', [], $locale) }}</div>
            </div>
            <div class="stat-card success">
                <div class="stat-value">{{ $avgAttendance }}%</div>
                <div class="stat-label">{{ trans('admin.reports.attendance.kpis.average_attendance', [], $locale) }}
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-value">{{ number_format($excellentCount) }}</div>
                <div class="stat-label">&ge; 95%</div>
            </div>
            <div class="stat-card danger">
                <div class="stat-value">{{ number_format($atRiskCount) }}</div>
                <div class="stat-label">{{ trans('admin.reports.attendance.kpis.at_risk', [], $locale) }}</div>
            </div>
        </div>

        {{-- Charts Section (only when no grade/section filter) --}}
        @if ($chartData)
            <div class="charts-section">
                {{-- Absences by Day of Week --}}
                <div class="chart-card">
                    <div class="chart-title">{{ trans('admin.reports.attendance.charts.absences_by_day', [], $locale) }}</div>
                    <div id="absencesByDayChart" class="chart-container"></div>
                </div>

                {{-- Attendance Distribution --}}
                <div class="chart-card">
                    <div class="chart-title">{{ trans('admin.reports.attendance.charts.distribution', [], $locale) }}</div>
                    <div id="distributionChart" class="chart-container"></div>
                </div>

                {{-- Absences by Grade --}}
                <div class="chart-card">
                    <div class="chart-title">{{ trans('admin.reports.attendance.charts.absences_by_grade', [], $locale) }}</div>
                    <div id="absencesByGradeChart" class="chart-container"></div>
                </div>
            </div>
        @endif

        {{-- Data Table --}}
        <div class="table-section">
            <div class="table-header">
                <h3 class="table-title">{{ trans('admin.reports.attendance.table.subtitle', [], $locale) }}</h3>
                <p class="table-subtitle">{{ $records->count() }}
                    {{ trans('admin.reports.attendance.table.records', [], $locale) }}</p>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ trans('admin.reports.attendance.table.student_name', [], $locale) }}</th>
                        <th>{{ trans('admin.reports.attendance.table.section', [], $locale) }}</th>
                        <th class="text-center">{{ trans('admin.reports.attendance.table.total_days', [], $locale) }}
                        </th>
                        <th class="text-center">{{ trans('admin.reports.attendance.table.present', [], $locale) }}</th>
                        <th class="text-center">{{ trans('admin.reports.attendance.table.absent', [], $locale) }}</th>
                        <th class="text-center">{{ trans('admin.reports.attendance.table.late', [], $locale) }}</th>
                        <th class="text-center" style="width: 100px;">
                            {{ trans('admin.reports.attendance.table.percentage', [], $locale) }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $index => $record)
                        <tr>
                            <td class="text-center">
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="student-name">{{ $record->student_name }}</span>
                            </td>
                            <td>{{ $record->section_name }}</td>
                            <td class="text-center">{{ $record->total_days }}</td>
                            <td class="text-center">{{ $record->present_days }}</td>
                            <td class="text-center">{{ $record->absent_days }}</td>
                            <td class="text-center">{{ $record->late_days }}</td>
                            <td class="text-center">
                                @php
                                    $percentage = (float) $record->attendance_percentage;
                                    $badgeClass = match (true) {
                                        $percentage >= 95 => 'badge-success',
                                        $percentage >= 85 => 'badge-warning',
                                        default => 'badge-danger',
                                    };
                                @endphp
                                <span class="badge-percentage {{ $badgeClass }}">
                                    {{ $percentage }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center" style="padding: 40px;">
                                {{ trans('admin.reports.attendance.charts.no_data', [], $locale) }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Report Footer --}}
        <div class="report-footer">
            <div class="footer-note">
                {{ trans('admin.attendances.print_footer', [], $locale) }}
            </div>
            <div class="footer-note">
                {{ config('app.name') }} &copy; {{ date('Y') }}
            </div>
        </div>
    </div>

    {{-- ApexCharts Initialization (only when charts are included) --}}
    @if ($chartData)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isRtl = {{ $isRtl ? 'true' : 'false' }};
                const fontFamily = isRtl ? 'Cairo, sans-serif' : 'Inter, sans-serif';

                // Chart data from backend
                const absencesByDay = @json($chartData['absencesByDay']);
                const absencesByGrade = @json($chartData['absencesByGrade']);
                const distribution = @json($chartData['distribution']);

                // Translation labels
                const labels = {
                    excellent: '{{ trans('admin.reports.attendance.charts.excellent', [], $locale) }}',
                    good: '{{ trans('admin.reports.attendance.charts.good', [], $locale) }}',
                    warning: '{{ trans('admin.reports.attendance.charts.warning', [], $locale) }}',
                    critical: '{{ trans('admin.reports.attendance.charts.critical', [], $locale) }}',
                    absences: '{{ trans('admin.reports.attendance.charts.absences', [], $locale) }}',
                };

                // 1. Absences by Day of Week (Bar Chart)
                const absencesByDayOptions = {
                    series: [{
                        name: labels.absences,
                        data: absencesByDay.values
                    }],
                    chart: {
                        type: 'bar',
                        height: 220,
                        fontFamily: fontFamily,
                        toolbar: { show: false },
                        animations: { enabled: false }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 6,
                            columnWidth: '60%',
                            distributed: true
                        }
                    },
                    colors: ['#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe', '#6366f1', '#818cf8', '#a5b4fc'],
                    dataLabels: {
                        enabled: true,
                        style: { fontSize: '11px', fontWeight: 600 }
                    },
                    xaxis: {
                        categories: absencesByDay.categories,
                        labels: { style: { fontSize: '10px' } }
                    },
                    yaxis: {
                        labels: { style: { fontSize: '10px' } }
                    },
                    grid: {
                        borderColor: '#e2e8f0',
                        strokeDashArray: 3
                    },
                    legend: { show: false }
                };

                new ApexCharts(document.querySelector("#absencesByDayChart"), absencesByDayOptions).render();

                // 2. Attendance Distribution (Donut Chart)
                const distributionOptions = {
                    series: [distribution.excellent, distribution.good, distribution.warning, distribution.critical],
                    chart: {
                        type: 'donut',
                        height: 220,
                        fontFamily: fontFamily,
                        animations: { enabled: false }
                    },
                    labels: [labels.excellent, labels.good, labels.warning, labels.critical],
                    colors: ['#10b981', '#6366f1', '#f59e0b', '#ef4444'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '55%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: '{{ trans('admin.reports.attendance.table.records', [], $locale) }}',
                                        fontSize: '12px',
                                        fontWeight: 600
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return opts.w.config.series[opts.seriesIndex];
                        },
                        style: { fontSize: '11px', fontWeight: 600 }
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '11px',
                        markers: { width: 10, height: 10 }
                    }
                };

                new ApexCharts(document.querySelector("#distributionChart"), distributionOptions).render();

                // 3. Absences by Grade (Horizontal Bar Chart)
                const absencesByGradeOptions = {
                    series: [{
                        name: labels.absences,
                        data: absencesByGrade.values
                    }],
                    chart: {
                        type: 'bar',
                        height: 220,
                        fontFamily: fontFamily,
                        toolbar: { show: false },
                        animations: { enabled: false }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: true,
                            borderRadius: 4,
                            barHeight: '70%',
                            distributed: true
                        }
                    },
                    colors: ['#ef4444', '#f59e0b', '#10b981', '#6366f1', '#8b5cf6', '#ec4899'],
                    dataLabels: {
                        enabled: true,
                        style: { fontSize: '11px', fontWeight: 600 }
                    },
                    xaxis: {
                        categories: absencesByGrade.categories,
                        labels: { style: { fontSize: '10px' } }
                    },
                    yaxis: {
                        labels: { style: { fontSize: '10px' } }
                    },
                    grid: {
                        borderColor: '#e2e8f0',
                        strokeDashArray: 3
                    },
                    legend: { show: false }
                };

                new ApexCharts(document.querySelector("#absencesByGradeChart"), absencesByGradeOptions).render();

                // Signal that charts are rendered (for Browsershot)
                window.chartsRendered = true;
            });
        </script>
    @endif
</body>

</html>
