@php
    $isRtl = $locale === 'ar';
    $direction = $isRtl ? 'rtl' : 'ltr';
    $textAlign = $isRtl ? 'right' : 'left';
    $fontFamily = $isRtl ? 'Cairo' : 'Inter';
@endphp

<!DOCTYPE html>
<html dir="{{ $direction }}" lang="{{ $locale }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.exports.grades_report_pdf.title') }}</title>

    <!-- Bootstrap RTL/LTR CSS -->
    @if ($isRtl)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Google Fonts -->
    @if ($isRtl)
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @endif

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: '{{ $fontFamily }}', sans-serif;
            direction: {{ $direction }};
            background: #ffffff;
            color: #1f2937;
            line-height: 1.6;
        }

        .pdf-container {
            max-width: 100%;
            padding: 20px;
        }

        /* Header */
        .pdf-header {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            text-align: center;
        }

        .pdf-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .pdf-header p {
            font-size: 14px;
            opacity: 0.95;
            margin: 5px 0;
        }

        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .kpi-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 24px;
        }

        .kpi-value {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .kpi-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
        }

        /* Charts */
        .chart-container {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: {{ $textAlign }};
        }

        .chart-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        /* Table */
        .table-container {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            overflow-x: auto;
        }

        .table-header {
            font-size: 20px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: {{ $textAlign }};
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        thead th {
            background: #f3f4f6;
            color: #374151;
            font-weight: 600;
            padding: 12px 10px;
            text-align: {{ $textAlign }};
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }

        tbody td {
            padding: 10px;
            border-bottom: 1px solid #f3f4f6;
            text-align: {{ $textAlign }};
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Footer */
        .pdf-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .chart-container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="pdf-container">
        <!-- Header -->
        <div class="pdf-header">
            <h1>{{ trans('admin.exports.grades_report_pdf.title') }}</h1>
            <p>{{ trans('admin.exports.grades_report.generated_on') }}: {{ $generatedAt->format('Y-m-d H:i:s') }}</p>
            <p>{{ trans('admin.Reports.reports.grades.table.records') }}: {{ number_format($records->count()) }}</p>
        </div>

        <!-- KPI Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #dbeafe; color: #1e40af;">
                    👨‍🎓
                </div>
                <div class="kpi-value">{{ number_format($kpis['total_students']) }}</div>
                <div class="kpi-label">{{ trans('admin.Reports.reports.grades.kpis.total_students') }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background: #d1fae5; color: #065f46;">
                    📊
                </div>
                <div class="kpi-value">{{ number_format($kpis['average_percentage'], 1) }}%</div>
                <div class="kpi-label">{{ trans('admin.Reports.reports.grades.kpis.average_percentage') }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background: #fef3c7; color: #92400e;">
                    ✅
                </div>
                <div class="kpi-value">{{ number_format($kpis['pass_rate'], 1) }}%</div>
                <div class="kpi-label">{{ trans('admin.Reports.reports.grades.kpis.pass_rate') }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background: #e0e7ff; color: #4338ca;">
                    📝
                </div>
                <div class="kpi-value">{{ number_format($kpis['total_exams']) }}</div>
                <div class="kpi-label">{{ trans('admin.Reports.reports.grades.kpis.total_exams') }}</div>
            </div>
        </div>

        @if ($chartData)
            <!-- Charts -->
            <div class="chart-grid">
                <!-- Score Distribution Chart -->
                <div class="chart-container">
                    <div class="chart-title">{{ trans('admin.Reports.reports.grades.charts.score_distribution') }}</div>
                    <div id="scoreDistributionChart"></div>
                </div>

                <!-- Subject Performance Chart -->
                <div class="chart-container">
                    <div class="chart-title">{{ trans('admin.Reports.reports.grades.charts.subject_performance') }}</div>
                    <div id="subjectPerformanceChart"></div>
                </div>

                <!-- Grade Comparison Chart -->
                <div class="chart-container">
                    <div class="chart-title">{{ trans('admin.Reports.reports.grades.charts.grade_comparison') }}</div>
                    <div id="gradeComparisonChart"></div>
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="table-container">
            <div class="table-header">{{ trans('admin.Reports.reports.grades.table.title') }}</div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('admin.exports.grades_report.student_name') }}</th>
                        <th>{{ trans('admin.exports.grades_report.grade') }}</th>
                        <th>{{ trans('admin.exports.grades_report.classroom') }}</th>
                        <th>{{ trans('admin.exports.grades_report.section') }}</th>
                        <th>{{ trans('admin.exports.grades_report.subject') }}</th>
                        <th>{{ trans('admin.exports.grades_report.exam') }}</th>
                        <th>{{ trans('admin.exports.grades_report.score') }}</th>
                        <th>{{ trans('admin.exports.grades_report.percentage') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->student_name }}</td>
                            <td>{{ $record->grade_name }}</td>
                            <td>{{ $record->classroom_name }}</td>
                            <td>{{ $record->section_name ?? '-' }}</td>
                            <td>{{ $record->subject_name }}</td>
                            <td>{{ $record->exam_title }}</td>
                            <td>{{ $record->final_score }} / {{ $record->total_marks }}</td>
                            <td>
                                @php
                                    $badgeClass =
                                        $record->percentage >= 80
                                            ? 'badge-success'
                                            : ($record->percentage >= 50
                                                ? 'badge-warning'
                                                : 'badge-danger');
                                @endphp
                                <span
                                    class="badge {{ $badgeClass }}">{{ number_format($record->percentage, 1) }}%</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="pdf-footer">
            <p>{{ trans('admin.exports.financial_report_pdf.auto_generated') }}</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>

    @if ($chartData)
        <script>
            // Score Distribution Chart
            const scoreDistributionOptions = {
                series: [{
                    name: '{{ trans('admin.Reports.reports.grades.charts.students') }}',
                    data: @json($chartData['scoreDistribution']['values'])
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    fontFamily: '{{ $fontFamily }}',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '70%',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        fontWeight: 600
                    }
                },
                colors: ['#ef4444', '#f97316', '#f59e0b', '#10b981', '#059669'],
                xaxis: {
                    categories: @json($chartData['scoreDistribution']['labels']),
                    labels: {
                        style: {
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    strokeDashArray: 4
                }
            };

            const scoreDistributionChart = new ApexCharts(
                document.querySelector("#scoreDistributionChart"),
                scoreDistributionOptions
            );
            scoreDistributionChart.render();

            // Subject Performance Chart
            const subjectPerformanceOptions = {
                series: [{
                    name: '{{ trans('admin.Reports.reports.grades.charts.average_score') }}',
                    data: @json($chartData['subjectPerformance']['values'])
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: '{{ $fontFamily }}',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        horizontal: true,
                        barHeight: '70%',
                        distributed: true
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 600
                    }
                },
                colors: ['#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#14b8a6', '#10b981', '#f59e0b'],
                xaxis: {
                    categories: @json($chartData['subjectPerformance']['labels']),
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '11px'
                        }
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    strokeDashArray: 4
                }
            };

            const subjectPerformanceChart = new ApexCharts(
                document.querySelector("#subjectPerformanceChart"),
                subjectPerformanceOptions
            );
            subjectPerformanceChart.render();

            // Grade Comparison Chart
            const gradeComparisonOptions = {
                series: [{
                    name: '{{ trans('admin.Reports.reports.grades.charts.average_score') }}',
                    data: @json($chartData['gradeComparison']['averages'])
                }, {
                    name: '{{ trans('admin.Reports.reports.grades.charts.pass_rate') }}',
                    data: @json($chartData['gradeComparison']['passRates'])
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    fontFamily: '{{ $fontFamily }}',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '60%'
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    },
                    style: {
                        fontSize: '11px',
                        fontWeight: 600
                    }
                },
                colors: ['#6366f1', '#10b981'],
                xaxis: {
                    categories: @json($chartData['gradeComparison']['labels']),
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0) + '%';
                        },
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '12px',
                    fontWeight: 500
                },
                grid: {
                    strokeDashArray: 4
                }
            };

            const gradeComparisonChart = new ApexCharts(
                document.querySelector("#gradeComparisonChart"),
                gradeComparisonOptions
            );
            gradeComparisonChart.render();
        </script>
    @endif
</body>

</html>
