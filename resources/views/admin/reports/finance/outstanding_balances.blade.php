@extends('admin.layouts.master')

@section('title', trans('admin.reports.financial.title'))

@section('css')
    {{-- Vite Assets (ApexCharts and other npm packages) - Only for Financial Reports --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    {{-- Financial Report Styles --}}
    <link href="{{ URL::asset('assets/admin/css/reports/financial-report.css') }}" rel="stylesheet">
    {{-- Finance Modal Styles --}}
    <link href="{{ URL::asset('assets/admin/css/student/finance.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-modern">
                        <li class="breadcrumb-item">
                            <i class="las la-chart-bar mr-1 ml-1"></i>
                            {{ trans('admin.reports.title') }}
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ trans('admin.reports.financial.title') }}
                        </li>
                    </ol>
                </nav>
                <h2 class="mb-0 mt-2 page-title">
                    {{ trans('admin.reports.financial.outstanding_balances') }}
                </h2>
                <p class="mb-0 mt-1 page-subtitle">
                    {{ trans('admin.reports.financial.subtitle') }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- ═══════════════════════════════════════════════════════════════════
         📊 KPI Cards Section
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">
        {{-- Total Outstanding Revenue --}}
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="kpi-card danger">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.total_outstanding') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-revenue">
                                {{ number_format($kpis['total_expected_revenue'], 2) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-coins"
                                    style="font-size: 1.125rem; color: var(--finance-danger); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.currency') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-hand-holding-usd kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Students with Outstanding Balances --}}
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="kpi-card primary">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.students_count') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-students">
                                {{ number_format($kpis['defaulters_count']) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-user-graduate"
                                    style="font-size: 1.125rem; color: var(--finance-primary); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.active_students') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-users kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Debt Per Student --}}
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <div class="kpi-card success">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.average_debt') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-average">
                                {{ number_format($kpis['average_debt'], 2) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-calculator"
                                    style="font-size: 1.125rem; color: var(--finance-success); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.per_student') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-chart-line kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         📈 Charts Section (Placeholder for ApexCharts)
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm mb-4">
        {{-- Revenue Trend Chart --}}
        <div class="col-xl-8 col-lg-12">
            <div class="card" style="border-radius: 16px; border: 1px solid rgba(67, 97, 238, 0.1); box-shadow: 0 8px 32px rgba(31, 38, 135, 0.12);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #4361ee; margin-bottom: 1rem;">
                        <i class="las la-chart-area mr-2 ml-2"></i>
                        {{ trans('admin.reports.financial.charts.revenue_trend') }}
                    </h5>
                    <div id="revenue-trend-chart"></div>
                </div>
            </div>
        </div>

        {{-- Student Distribution Chart --}}
        <div class="col-xl-4 col-lg-12">
            <div class="card" style="border-radius: 16px; border: 1px solid rgba(67, 97, 238, 0.1); box-shadow: 0 8px 32px rgba(31, 38, 135, 0.12);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #4361ee; margin-bottom: 1rem;">
                        <i class="las la-chart-pie mr-2 ml-2"></i>
                        {{ trans('admin.reports.financial.charts.distribution') }}
                    </h5>
                    <div id="student-distribution-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-sm mb-4">
        {{-- Payment Timeline Chart --}}
        <div class="col-12">
            <div class="card" style="border-radius: 16px; border: 1px solid rgba(67, 97, 238, 0.1); box-shadow: 0 8px 32px rgba(31, 38, 135, 0.12);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #4361ee; margin-bottom: 1rem;">
                        <i class="las la-chart-bar mr-2 ml-2"></i>
                        {{ trans('admin.reports.financial.charts.payment_timeline') }}
                    </h5>
                    <div id="payment-timeline-chart"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         📋 Outstanding Balances Table
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="row row-sm">
        <div class="col-12">
            <div class="glass-table-card">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h3 class="section-title mb-0">
                                {{ trans('admin.reports.financial.table.title') }}
                            </h3>
                            <p class="section-subtitle mb-0">
                                {{ trans('admin.reports.financial.table.subtitle') }}
                            </p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge badge-primary"
                                style="padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600; border-radius: 10px;">
                                <i class="las la-database mr-1 ml-1"></i>
                                {{ number_format($kpis['defaulters_count']) }}
                                {{ trans('admin.reports.financial.table.records') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3 pb-4 px-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover mb-0" id="outstanding_balances_table"
                            width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="wd-25p">
                                        <i class="las la-user mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.student_name') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-receipt mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.total_charges') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-money-bill-wave mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.total_payments') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-exclamation-triangle mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.net_balance') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-calendar-check mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.last_payment') }}
                                    </th>
                                    <th class="wd-10p text-center">
                                        <i class="las la-cog mr-1 ml-1"></i>
                                        {{ trans('admin.global.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════════
         💰 Student Finance Modal
    ════════════════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="financeModal" tabindex="-1" role="dialog" aria-labelledby="financeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 900px;">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div id="financeModalContent">
                    <div class="text-center p-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">{{ trans('admin.global.loading') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(function() {
            'use strict';

            // ────────────────────────────────────────────────────────────
            // ⚡ High-Performance DataTable Configuration
            // ────────────────────────────────────────────────────────────
            const table = $('#outstanding_balances_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                responsive: false,
                deferRender: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: '{{ route('admin.reports.financial.outstanding-balances') }}',
                    type: 'GET',
                    error: function(xhr, error, code) {
                        console.error('DataTable Error:', error);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        width: '5%'
                    },
                    {
                        data: 'name',
                        name: 'students.name',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                const initial = data.charAt(0).toUpperCase();
                                return `
                                    <div class="d-flex align-items-center">
                                        <div class="student-avatar">${initial}</div>
                                        <div>
                                            <div style="font-weight: 600; font-size: 0.9375rem;">
                                                ${data}
                                            </div>
                                            <div style="font-size: 0.75rem; color: #6c757d; margin-top: 2px;">
                                                ID: ${row.id}
                                            </div>
                                        </div>
                                    </div>
                                `;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'total_charges',
                        name: 'total_charges',
                        className: 'text-center',
                        render: function(data) {
                            return `<span style="font-weight: 600; color: #6c757d; font-size: 0.9375rem;">
                                        ${parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                                    </span>`;
                        }
                    },
                    {
                        data: 'total_payments',
                        name: 'total_payments',
                        className: 'text-center',
                        render: function(data) {
                            return `<span style="font-weight: 600; color: #06d6a0; font-size: 0.9375rem;">
                                        ${parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                                    </span>`;
                        }
                    },
                    {
                        data: 'net_balance',
                        name: 'net_balance',
                        className: 'text-center',
                        render: function(data) {
                            return `<div class="currency-badge">
                                        <i class="las la-exclamation-circle"></i>
                                        <span>${parseFloat(data).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                                    </div>`;
                        }
                    },
                    {
                        data: 'last_payment_date',
                        name: 'last_payment_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [4, 'desc']
                ], // Sort by net_balance descending
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "{{ trans('admin.global.all') }}"]
                ],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                drawCallback: function() {
                    // Add subtle animation when table redraws
                    $('#outstanding_balances_table tbody tr').each(function(index) {
                        $(this).css({
                            'animation': `fadeInUp 0.4s ease ${index * 0.02}s both`,
                            'animation-fill-mode': 'both'
                        });
                    });
                }
            });

            // Add fadeInUp animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            `;
            document.head.appendChild(style);

            // Animate KPI cards on load
            $('.kpi-card').each(function(index) {
                $(this).css({
                    'animation': `fadeInUp 0.6s ease ${index * 0.15}s both`
                });
            });

            // Animate chart placeholders
            $('.chart-placeholder').each(function(index) {
                $(this).css({
                    'animation': `fadeInUp 0.6s ease ${0.45 + (index * 0.1)}s both`
                });
            });

            // Performance: Use passive event listeners
            if ('passive' in document.createElement('div')) {
                document.addEventListener('scroll', function() {}, {
                    passive: true
                });
            }

            // Accessibility: Add ARIA labels
            $('#outstanding_balances_table').attr('aria-label',
                '{{ trans('admin.reports.financial.table.title') }}');

            console.log('✨ Financial Report initialized successfully');

            // ────────────────────────────────────────────────────────────
            // 📊 Modern ApexCharts Implementation
            // ────────────────────────────────────────────────────────────

            // Chart data from server
            const chartData = @json($chartData);

            // Detect dark mode
            const isDarkMode = document.documentElement.classList.contains('dark-theme') ||
                             document.body.classList.contains('dark-theme');

            // 🎨 Modern Color Palette (2024 Design Trends)
            const colors = {
                // Primary modern colors
                charges: '#F43F5E',      // Rose 500 - Modern red/pink
                payments: '#10B981',      // Emerald 500 - Fresh green
                outstanding: '#F59E0B',   // Amber 500 - Warm yellow
                primary: '#6366F1',       // Indigo 500 - Modern purple-blue

                // Distribution chart colors (Gradient feel)
                dist1: '#22C55E',         // Green 500 - Low debt
                dist2: '#3B82F6',         // Blue 500 - Medium debt
                dist3: '#F59E0B',         // Amber 500 - High debt
                dist4: '#EF4444',         // Red 500 - Very high debt

                // Grid and text colors
                gridLight: '#E5E7EB',
                gridDark: 'rgba(255,255,255,0.1)',
                textLight: '#6B7280',
                textDark: '#9CA3AF'
            };

            // Common chart configuration
            const commonConfig = {
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                background: 'transparent',
                foreColor: isDarkMode ? '#E5E7EB' : '#374151'
            };

            // Grid configuration
            const gridConfig = {
                show: true,
                borderColor: isDarkMode ? colors.gridDark : colors.gridLight,
                strokeDashArray: 4,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            };

            // 1. Revenue Trend Chart (Modern Area Chart)
            const revenueTrendOptions = {
                chart: {
                    type: 'area',
                    height: 380,
                    ...commonConfig,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: true,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: true
                        },
                        autoSelected: 'zoom'
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 150
                        },
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    },
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 0,
                        blur: 4,
                        opacity: 0.1
                    }
                },
                series: [{
                    name: '{{ trans('admin.reports.financial.charts.charges') }}',
                    data: chartData.revenueTrend.charges
                }, {
                    name: '{{ trans('admin.reports.financial.charts.payments') }}',
                    data: chartData.revenueTrend.payments
                }, {
                    name: '{{ trans('admin.reports.financial.charts.outstanding') }}',
                    data: chartData.revenueTrend.outstanding
                }],
                colors: [colors.charges, colors.payments, colors.outstanding],
                xaxis: {
                    categories: chartData.revenueTrend.categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: isDarkMode ? colors.textDark : colors.textLight,
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDarkMode ? colors.textDark : colors.textLight,
                            fontSize: '12px',
                            fontWeight: 500
                        },
                        formatter: function(val) {
                            if (val >= 1000) {
                                return '$' + (val / 1000).toFixed(0) + 'K';
                            }
                            return '$' + val.toFixed(0);
                        }
                    }
                },
                grid: gridConfig,
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: [3, 3, 3],
                    lineCap: 'round'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    fontSize: '13px',
                    fontWeight: 600,
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12
                    },
                    itemMargin: { horizontal: 15, vertical: 8 }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: { fontSize: '13px' },
                    y: {
                        formatter: function(val) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    },
                    marker: { show: true }
                },
                markers: {
                    size: 0,
                    hover: { size: 6, sizeOffset: 3 }
                }
            };

            // 2. Student Distribution Chart (Modern Donut)
            const studentDistributionOptions = {
                chart: {
                    type: 'donut',
                    height: 380,
                    ...commonConfig,
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    },
                    dropShadow: {
                        enabled: true,
                        top: 2,
                        left: 0,
                        blur: 8,
                        opacity: 0.15
                    }
                },
                series: chartData.studentDistribution.values,
                labels: chartData.studentDistribution.labels,
                colors: [colors.dist1, colors.dist2, colors.dist3, colors.dist4],
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270,
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: isDarkMode ? '#E5E7EB' : '#374151',
                                    offsetY: -10
                                },
                                value: {
                                    show: true,
                                    fontSize: '28px',
                                    fontWeight: 700,
                                    color: isDarkMode ? '#F3F4F6' : '#111827',
                                    offsetY: 5,
                                    formatter: function(val) {
                                        return val;
                                    }
                                },
                                total: {
                                    show: true,
                                    label: '{{ trans('admin.reports.financial.charts.total_students') }}',
                                    fontSize: '13px',
                                    fontWeight: 500,
                                    color: isDarkMode ? '#9CA3AF' : '#6B7280',
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                stroke: {
                    show: true,
                    width: 3,
                    colors: [isDarkMode ? '#1F2937' : '#ffffff']
                },
                legend: {
                    position: 'bottom',
                    fontSize: '13px',
                    fontWeight: 600,
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12
                    },
                    itemMargin: { horizontal: 12, vertical: 8 }
                },
                tooltip: {
                    enabled: true,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: { fontSize: '13px' },
                    y: {
                        formatter: function(val) {
                            return val + ' {{ trans('admin.reports.financial.charts.students') }}';
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { height: 300 },
                        legend: { position: 'bottom' }
                    }
                }]
            };

            // 3. Payment Timeline Chart (Modern Column Chart)
            const paymentTimelineOptions = {
                chart: {
                    type: 'bar',
                    height: 380,
                    ...commonConfig,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800,
                        animateGradually: {
                            enabled: true,
                            delay: 100
                        }
                    }
                },
                series: [{
                    name: '{{ trans('admin.reports.financial.charts.charges') }}',
                    data: chartData.paymentTimeline.charges
                }, {
                    name: '{{ trans('admin.reports.financial.charts.payments') }}',
                    data: chartData.paymentTimeline.payments
                }],
                colors: [colors.charges, colors.payments],
                xaxis: {
                    categories: chartData.paymentTimeline.categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: isDarkMode ? colors.textDark : colors.textLight,
                            fontSize: '12px',
                            fontWeight: 500
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDarkMode ? colors.textDark : colors.textLight,
                            fontSize: '12px',
                            fontWeight: 500
                        },
                        formatter: function(val) {
                            if (val >= 1000) {
                                return '$' + (val / 1000).toFixed(0) + 'K';
                            }
                            return '$' + val.toFixed(0);
                        }
                    }
                },
                grid: gridConfig,
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '60%',
                        borderRadius: 8,
                        borderRadiusApplication: 'end',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    fontSize: '13px',
                    fontWeight: 600,
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 12
                    },
                    itemMargin: { horizontal: 15, vertical: 8 }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: { fontSize: '13px' },
                    y: {
                        formatter: function(val) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 0.9
                        }
                    },
                    active: {
                        filter: {
                            type: 'darken',
                            value: 0.85
                        }
                    }
                }
            };

            // Render Charts
            const revenueTrendChart = new ApexCharts(document.querySelector("#revenue-trend-chart"), revenueTrendOptions);
            const studentDistributionChart = new ApexCharts(document.querySelector("#student-distribution-chart"), studentDistributionOptions);
            const paymentTimelineChart = new ApexCharts(document.querySelector("#payment-timeline-chart"), paymentTimelineOptions);

            // Render all charts
            revenueTrendChart.render();
            studentDistributionChart.render();
            paymentTimelineChart.render();

            // Dark mode toggle handler with full theme update
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const newIsDarkMode = document.documentElement.classList.contains('dark-theme') ||
                                             document.body.classList.contains('dark-theme');

                        // Update all charts with new theme
                        const newGridColor = newIsDarkMode ? 'rgba(255,255,255,0.1)' : '#E5E7EB';
                        const newTextColor = newIsDarkMode ? '#9CA3AF' : '#6B7280';
                        const newForeColor = newIsDarkMode ? '#E5E7EB' : '#374151';

                        const themeUpdate = {
                            chart: { foreColor: newForeColor },
                            grid: { borderColor: newGridColor },
                            xaxis: { labels: { style: { colors: newTextColor } } },
                            yaxis: { labels: { style: { colors: newTextColor } } },
                            tooltip: { theme: newIsDarkMode ? 'dark' : 'light' }
                        };

                        revenueTrendChart.updateOptions(themeUpdate);
                        paymentTimelineChart.updateOptions(themeUpdate);
                        studentDistributionChart.updateOptions({
                            chart: { foreColor: newForeColor },
                            stroke: { colors: [newIsDarkMode ? '#1F2937' : '#ffffff'] },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        labels: {
                                            name: { color: newIsDarkMode ? '#E5E7EB' : '#374151' },
                                            value: { color: newIsDarkMode ? '#F3F4F6' : '#111827' },
                                            total: { color: newIsDarkMode ? '#9CA3AF' : '#6B7280' }
                                        }
                                    }
                                }
                            },
                            tooltip: { theme: newIsDarkMode ? 'dark' : 'light' }
                        });
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
            observer.observe(document.body, {
                attributes: true,
                attributeFilter: ['class']
            });

            console.log('📊 Modern ApexCharts initialized successfully');
        });

        // ────────────────────────────────────────────────────────────
        // 💼 Student Finance Modal Handler
        // ────────────────────────────────────────────────────────────
        $(document).on('click', '.student-finance-btn', function(e) {
            e.preventDefault();
            const studentId = $(this).data('student-id');
            const modal = $('#financeModal');
            const modalContent = $('#financeModalContent');

            // Show modal with loading state
            modal.modal('show');
            modalContent.html(`
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">{{ trans('admin.global.loading') }}</p>
                </div>
            `);

            // Fetch finance data
            $.ajax({
                url: `/admin/students/${studentId}/finance`,
                method: 'GET',
                success: function(response) {
                    modalContent.html(response);
                },
                error: function(xhr, status, error) {
                    modalContent.html(`
                        <div class="modal-header border-0">
                            <h5 class="modal-title text-danger">
                                <i class="las la-exclamation-triangle mr-2 ml-2"></i>
                                {{ trans('admin.global.error') }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center p-5">
                            <p class="text-muted">{{ trans('admin.global.error_loading') }}</p>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                {{ trans('admin.global.close') }}
                            </button>
                        </div>
                    `);
                    console.error('Error loading finance data:', error);
                }
            });
        });
    </script>
@endsection
