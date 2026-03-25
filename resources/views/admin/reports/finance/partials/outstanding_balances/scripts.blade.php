    <script>
        $(function() {
            'use strict';

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
                ],
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "{{ trans('admin.global.all') }}"]
                ],
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                drawCallback: function() {
                    $('#outstanding_balances_table tbody tr').each(function(index) {
                        $(this).css({
                            'animation': `fadeInUp 0.4s ease ${index * 0.02}s both`,
                            'animation-fill-mode': 'both'
                        });
                    });
                }
            });

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

            $('.kpi-card').each(function(index) {
                $(this).css({
                    'animation': `fadeInUp 0.6s ease ${index * 0.15}s both`
                });
            });

            $('.chart-placeholder').each(function(index) {
                $(this).css({
                    'animation': `fadeInUp 0.6s ease ${0.45 + (index * 0.1)}s both`
                });
            });

            if ('passive' in document.createElement('div')) {
                document.addEventListener('scroll', function() {}, {
                    passive: true
                });
            }

            $('#outstanding_balances_table').attr('aria-label',
                '{{ trans('admin.reports.financial.table.title') }}');

            console.log('✨ Financial Report initialized successfully');

            const chartData = @json($chartData);
            const isDarkMode = document.documentElement.classList.contains('dark-theme') ||
                document.body.classList.contains('dark-theme');

            const colors = {
                charges: '#F43F5E',
                payments: '#10B981',
                outstanding: '#F59E0B',
                primary: '#6366F1',
                dist1: '#22C55E',
                dist2: '#3B82F6',
                dist3: '#F59E0B',
                dist4: '#EF4444',
                gridLight: '#E5E7EB',
                gridDark: 'rgba(255,255,255,0.1)',
                textLight: '#6B7280',
                textDark: '#9CA3AF'
            };

            const commonConfig = {
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif',
                background: 'transparent',
                foreColor: isDarkMode ? '#E5E7EB' : '#374151'
            };

            const gridConfig = {
                show: true,
                borderColor: isDarkMode ? colors.gridDark : colors.gridLight,
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: false
                    }
                },
                yaxis: {
                    lines: {
                        show: true
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 10
                }
            };

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
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
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
                dataLabels: {
                    enabled: false
                },
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
                    itemMargin: {
                        horizontal: 15,
                        vertical: 8
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: {
                        fontSize: '13px'
                    },
                    y: {
                        formatter: function(val) {
                            return new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 0
                            }).format(val);
                        }
                    },
                    marker: {
                        show: true
                    }
                },
                markers: {
                    size: 0,
                    hover: {
                        size: 6,
                        sizeOffset: 3
                    }
                }
            };

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
                    itemMargin: {
                        horizontal: 12,
                        vertical: 8
                    }
                },
                tooltip: {
                    enabled: true,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: {
                        fontSize: '13px'
                    },
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
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };

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
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
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
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: false
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
                    itemMargin: {
                        horizontal: 15,
                        vertical: 8
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    theme: isDarkMode ? 'dark' : 'light',
                    style: {
                        fontSize: '13px'
                    },
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

            const revenueTrendChart = new ApexCharts(document.querySelector("#revenue-trend-chart"),
                revenueTrendOptions);
            const studentDistributionChart = new ApexCharts(document.querySelector("#student-distribution-chart"),
                studentDistributionOptions);
            const paymentTimelineChart = new ApexCharts(document.querySelector("#payment-timeline-chart"),
                paymentTimelineOptions);

            revenueTrendChart.render();
            studentDistributionChart.render();
            paymentTimelineChart.render();

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const newIsDarkMode = document.documentElement.classList.contains(
                                'dark-theme') ||
                            document.body.classList.contains('dark-theme');

                        const newGridColor = newIsDarkMode ? 'rgba(255,255,255,0.1)' : '#E5E7EB';
                        const newTextColor = newIsDarkMode ? '#9CA3AF' : '#6B7280';
                        const newForeColor = newIsDarkMode ? '#E5E7EB' : '#374151';

                        const themeUpdate = {
                            chart: {
                                foreColor: newForeColor
                            },
                            grid: {
                                borderColor: newGridColor
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        colors: newTextColor
                                    }
                                }
                            },
                            yaxis: {
                                labels: {
                                    style: {
                                        colors: newTextColor
                                    }
                                }
                            },
                            tooltip: {
                                theme: newIsDarkMode ? 'dark' : 'light'
                            }
                        };

                        revenueTrendChart.updateOptions(themeUpdate);
                        paymentTimelineChart.updateOptions(themeUpdate);
                        studentDistributionChart.updateOptions({
                            chart: {
                                foreColor: newForeColor
                            },
                            stroke: {
                                colors: [newIsDarkMode ? '#1F2937' : '#ffffff']
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        labels: {
                                            name: {
                                                color: newIsDarkMode ? '#E5E7EB' : '#374151'
                                            },
                                            value: {
                                                color: newIsDarkMode ? '#F3F4F6' : '#111827'
                                            },
                                            total: {
                                                color: newIsDarkMode ? '#9CA3AF' : '#6B7280'
                                            }
                                        }
                                    }
                                }
                            },
                            tooltip: {
                                theme: newIsDarkMode ? 'dark' : 'light'
                            }
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

        });

        $(document).on('click', '.student-finance-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.data('url');
            var $modal = $('#financeModal');
            var $content = $('#financeModalContent');

            $content.html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                </div>
            `);

            $modal.modal('show');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    $content.html(response);
                },
                error: function(xhr, status, error) {
                    $content.html(`
                        <div class="modal-header border-0">
                            <h5 class="modal-title text-danger">
                                {{ trans('admin.global.error') }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center py-5">
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

        $('#financeModal').on('hidden.bs.modal', function() {
            $('#financeModalContent').html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                </div>
            `);
        });

        // ─── Export Functionality ──────────────────────────────────
        @can('export_financial-reports')
            $('#btn-export-excel').on('click', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const originalText = $btn.html();

                $btn.prop('disabled', true).html('<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}');

                $.ajax({
                    url: '{{ route('admin.exports.financial') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        swal({
                            type: 'success',
                            title: '{{ trans('admin.global.success') }}',
                            text: response.message,
                            confirmButtonText: '{{ trans('admin.global.ok') }}'
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = '{{ trans('admin.global.error') }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        swal({
                            type: 'error',
                            title: '{{ trans('admin.global.error_title') }}',
                            text: errorMessage,
                            confirmButtonText: '{{ trans('admin.global.ok') }}'
                        });
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            });

            $('#btn-export-pdf').on('click', function(e) {
                e.preventDefault();
                const $btn = $(this);
                const originalText = $btn.html();

                $btn.prop('disabled', true).html('<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}');

                $.ajax({
                    url: '{{ route('admin.exports.financial-pdf') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        swal({
                            type: 'success',
                            title: '{{ trans('admin.global.success') }}',
                            text: response.message,
                            confirmButtonText: '{{ trans('admin.global.ok') }}'
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = '{{ trans('admin.global.error') }}';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        swal({
                            type: 'error',
                            title: '{{ trans('admin.global.error_title') }}',
                            text: errorMessage,
                            confirmButtonText: '{{ trans('admin.global.ok') }}'
                        });
                    },
                    complete: function() {
                        $btn.prop('disabled', false).html(originalText);
                    }
                });
            });
        @endcan
    </script>
