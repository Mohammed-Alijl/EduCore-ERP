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
    <title>{{ trans('admin.exports.financial_report_pdf.title') }}</title>

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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            grid-template-columns: repeat(3, 1fr);
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
            font-size: 24px;
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
            <h1>{{ trans('admin.exports.financial_report_pdf.title') }}</h1>
            <p>{{ trans('admin.exports.financial_report.generated_on') }}: {{ $generatedAt->format('Y-m-d H:i:s') }}</p>
            <p>{{ trans('admin.reports.financial.table.records') }}: {{ number_format($records->count()) }}</p>
        </div>

        <!-- KPI Cards -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-icon" style="background: #fee2e2; color: #dc2626;">
                    💰
                </div>
                <div class="kpi-value">{{ number_format($kpis['total_expected_revenue'], 2) }}</div>
                <div class="kpi-label">{{ trans('admin.reports.financial.kpis.total_outstanding') }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background: #e0e7ff; color: #4f46e5;">
                    👥
                </div>
                <div class="kpi-value">{{ number_format($kpis['defaulters_count']) }}</div>
                <div class="kpi-label">{{ trans('admin.reports.financial.kpis.students_count') }}</div>
            </div>

            <div class="kpi-card">
                <div class="kpi-icon" style="background: #d1fae5; color: #059669;">
                    📈
                </div>
                <div class="kpi-value">{{ number_format($kpis['average_debt'], 2) }}</div>
                <div class="kpi-label">{{ trans('admin.reports.financial.kpis.average_debt') }}</div>
            </div>
        </div>

        @if ($chartData)
            <!-- Charts -->
            <div class="chart-grid">
                <!-- Revenue Trend Chart -->
                <div class="chart-container">
                    <div class="chart-title">{{ trans('admin.reports.financial.charts.revenue_trend') }}</div>
                    <div id="revenueTrendChart"></div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <!-- Student Distribution Chart -->
                    <div class="chart-container">
                        <div class="chart-title">{{ trans('admin.reports.financial.charts.student_distribution') }}</div>
                        <div id="studentDistributionChart"></div>
                    </div>
    
                    <!-- Payment Timeline Chart -->
                    <div class="chart-container">
                        <div class="chart-title">{{ trans('admin.reports.financial.charts.payment_timeline') }}</div>
                        <div id="paymentTimelineChart"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="table-container">
            <div class="table-header">{{ trans('admin.reports.financial.table.title') }}</div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('admin.exports.financial_report.student_name') }}</th>
                        <th>{{ trans('admin.exports.financial_report.total_charges') }}</th>
                        <th>{{ trans('admin.exports.financial_report.total_payments') }}</th>
                        <th>{{ trans('admin.exports.financial_report.net_balance') }}</th>
                        <th>{{ trans('admin.exports.financial_report.last_payment_date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->name }}</td>
                            <td>{{ number_format($record->total_charges, 2) }}</td>
                            <td>{{ number_format($record->total_payments, 2) }}</td>
                            <td><span class="badge {{ $record->net_balance > 0 ? 'badge-danger' : 'badge-success' }}">{{ number_format($record->net_balance, 2) }}</span></td>
                            <td>{{ $record->last_payment_date ? \Carbon\Carbon::parse($record->last_payment_date)->format('Y-m-d') : trans('admin.exports.financial_report.no_payment') }}</td>
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
            // Common Config
            const commonConfig = {
                fontFamily: '{{ $fontFamily }}',
                background: 'transparent',
                foreColor: '#374151'
            };

            const gridConfig = {
                borderColor: '#E5E7EB',
                strokeDashArray: 4
            };

            // Revenue Trend Chart
            const revenueTrendOptions = {
                chart: {
                    type: 'area',
                    height: 300,
                    ...commonConfig,
                    toolbar: { show: false },
                    animations: { enabled: false }
                },
                series: [{
                    name: '{{ trans('admin.reports.financial.charts.charges') }}',
                    data: @json($chartData['revenueTrend']['charges'])
                }, {
                    name: '{{ trans('admin.reports.financial.charts.payments') }}',
                    data: @json($chartData['revenueTrend']['payments'])
                }, {
                    name: '{{ trans('admin.reports.financial.charts.outstanding') }}',
                    data: @json($chartData['revenueTrend']['outstanding'])
                }],
                colors: ['#F43F5E', '#10B981', '#F59E0B'],
                xaxis: {
                    categories: @json($chartData['revenueTrend']['categories']),
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontWeight: 500
                        }
                    }
                },
                grid: gridConfig,
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: [2, 2, 2]
                },
                legend: { position: 'top' }
            };

            new ApexCharts(document.querySelector("#revenueTrendChart"), revenueTrendOptions).render();

            // Student Distribution Chart
            const studentDistributionOptions = {
                chart: {
                    type: 'donut',
                    height: 250,
                    ...commonConfig,
                    animations: { enabled: false }
                },
                series: @json($chartData['studentDistribution']['values']),
                labels: @json($chartData['studentDistribution']['labels']),
                colors: ['#22C55E', '#3B82F6', '#F59E0B', '#EF4444'],
                legend: { position: 'bottom' },
                dataLabels: { enabled: false }
            };

            new ApexCharts(document.querySelector("#studentDistributionChart"), studentDistributionOptions).render();

            // Payment Timeline Chart
            const paymentTimelineOptions = {
                chart: {
                    type: 'bar',
                    height: 250,
                    ...commonConfig,
                    toolbar: { show: false },
                    animations: { enabled: false }
                },
                series: [{
                    name: '{{ trans('admin.reports.financial.charts.charges') }}',
                    data: @json($chartData['paymentTimeline']['charges'])
                }, {
                    name: '{{ trans('admin.reports.financial.charts.payments') }}',
                    data: @json($chartData['paymentTimeline']['payments'])
                }],
                colors: ['#F43F5E', '#10B981'],
                xaxis: {
                    categories: @json($chartData['paymentTimeline']['categories']),
                    labels: { style: { fontSize: '10px' } }
                },
                grid: gridConfig,
                dataLabels: { enabled: false },
                legend: { position: 'top' }
            };

            new ApexCharts(document.querySelector("#paymentTimelineChart"), paymentTimelineOptions).render();
        </script>
    @endif
</body>

</html>
