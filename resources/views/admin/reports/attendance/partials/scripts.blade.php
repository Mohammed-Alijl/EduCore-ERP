<script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('assets/admin/plugins/sweet-alert/jquery.sweet-alert.js') }}"></script>
<script>
    $(function() {
        // ─── Chart Theme ───────────────────────────────────────────
        const isDark = $('body').hasClass('dark-theme');
        const chartTheme = {
            foreColor: isDark ? '#94a3b8' : '#64748b',
            background: 'transparent',
        };
        const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

        // ─── Absences by Day of Week Chart ─────────────────────────
        const dayData = @json($chartData['absencesByDay']);
        const absencesDayChart = new ApexCharts(document.querySelector('#absences-by-day-chart'), {
            series: [{
                name: @json(trans('admin.reports.attendance.charts.absences_count')),
                data: dayData.values
            }],
            chart: {
                type: 'bar',
                height: 320,
                background: chartTheme.background,
                foreColor: chartTheme.foreColor,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '55%',
                    distributed: true,
                }
            },
            colors: ['#ef4444', '#f97316', '#f59e0b', '#6366f1', '#10b981', '#06b6d4', '#8b5cf6'],
            dataLabels: {
                enabled: true,
                style: {
                    fontWeight: 700,
                    fontSize: '13px'
                }
            },
            xaxis: {
                categories: dayData.categories,
                labels: {
                    style: {
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                title: {
                    text: @json(trans('admin.reports.attendance.charts.absences_count')),
                    style: {
                        fontWeight: 700
                    }
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4
            },
            legend: {
                show: false
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light'
            }
        });
        absencesDayChart.render();

        // ─── Absences by Grade Donut Chart ─────────────────────────
        const gradeData = @json($chartData['absencesByGrade']);
        const gradeChartOptions = {
            series: gradeData.values,
            labels: gradeData.categories,
            chart: {
                type: 'donut',
                height: 320,
                background: chartTheme.background,
                foreColor: chartTheme.foreColor,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
                    }
                }
            },
            colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316'],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                offsetY: 0,
                fontSize: '13px',
                fontWeight: 600,
                markers: {
                    radius: 12
                }
            },
            stroke: {
                show: true,
                colors: [isDark ? '#1e2130' : '#ffffff'],
                width: 2
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light'
            }
        };
        const absencesGradeChart = new ApexCharts(document.querySelector('#absences-by-grade-chart'),
            gradeChartOptions);
        absencesGradeChart.render();

        // ─── DataTable ─────────────────────────────────────────────
        const attendanceTable = $('#attendance_report_table').DataTable(getTableConfig({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.reports.attendance.index') }}',
                data: function(d) {
                    d.academic_year_id = $('#filter-academic-year').val();
                },
                dataSrc: function(json) {
                    if (json.recordsTotal !== undefined) {
                        $('#records-count').text(json.recordsTotal.toLocaleString());
                    }
                    return json.data;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'student_name',
                    name: 'student_name'
                },
                {
                    data: 'section_name',
                    name: 'section_name'
                },
                {
                    data: 'total_days',
                    name: 'total_days',
                    className: 'text-center'
                },
                {
                    data: 'present_days',
                    name: 'present_days',
                    className: 'text-center'
                },
                {
                    data: 'absent_days',
                    name: 'absent_days',
                    className: 'text-center'
                },
                {
                    data: 'late_days',
                    name: 'late_days',
                    className: 'text-center'
                },
                {
                    data: 'attendance_percentage',
                    name: 'attendance_percentage',
                    className: 'text-center'
                },
            ],
            order: [
                [7, 'asc']
            ],
            drawCallback: function() {
                $('#attendance_report_table tbody tr').each(function(index) {
                    $(this).css('animation', 'fadeInUp 0.3s ease forwards');
                    $(this).css('animation-delay', (index * 0.03) + 's');
                    $(this).css('opacity', '0');
                });
            }
        }));

        // ─── Filter Form Submit ────────────────────────────────────
        $('#attendance-filter-form').on('submit', function(e) {
            e.preventDefault();
            const params = new URLSearchParams($(this).serialize());
            Array.from(params.entries()).forEach(([key, value]) => {
                if (!value) params.delete(key);
            });
            const queryString = params.toString();
            const url = '{{ route('admin.reports.attendance.index') }}' + (queryString ? '?' +
                queryString : '');
            window.location.href = url;
        });

        // ─── Reset Filters ─────────────────────────────────────────
        $('#btn-reset-filters').on('click', function() {
            window.location.href = '{{ route('admin.reports.attendance.index') }}';
        });

        // ─── Animation Keyframes ───────────────────────────────────
        $('<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}</style>')
            .appendTo('head');

        // ─── Export Modal Logic ─────────────────────────────────────
        @can('export_attendance-reports')
            const $exportGrade = $('#export-grade');
            const $exportSection = $('#export-section');

            // Load grades on modal open
            $('#exportModal').on('show.bs.modal', function() {
                loadGrades();
                $exportSection.val('').prop('disabled', true);
            });

            function loadGrades() {
                $.ajax({
                    url: '{{ route('admin.grades.index') }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $exportGrade.html(
                            '<option value="">{{ trans('admin.global.all') }}</option>');
                        if (response.data && response.data.length) {
                            response.data.forEach(function(grade) {
                                $exportGrade.append(
                                    `<option value="${grade.id}">${grade.name}</option>`
                                );
                            });
                        }
                    },
                    error: function() {
                        console.error('Failed to load grades');
                    }
                });
            }

            // Load sections on grade change
            $exportGrade.on('change', function() {
                const gradeId = $(this).val();
                $exportSection.val('').prop('disabled', true);

                if (!gradeId) return;

                $.ajax({
                    url: '{{ route('admin.get_sections_by_grade') }}',
                    type: 'GET',
                    data: {
                        grade_id: gradeId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $exportSection.html(
                            '<option value="">{{ trans('admin.global.all') }}</option>');
                        if (response && response.success && response.data) {
                            $.each(response.data, function(id, name) {
                                $exportSection.append(
                                    `<option value="${id}">${name}</option>`
                                );
                            });
                            $exportSection.prop('disabled', false);
                        }
                    },
                    error: function() {
                        console.error('Failed to load sections');
                    }
                });
            });

            // Handle export form submission
            $('#export-form').on('submit', function(e) {
                e.preventDefault();

                const $btn = $('#btn-submit-export');
                const originalText = $btn.html();

                $btn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}'
                );

                $.ajax({
                    url: '{{ route('admin.exports.attendance') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        academic_year_id: $('#export-academic-year').val(),
                        grade_id: $exportGrade.val() || null,
                        section_id: $exportSection.val() || null
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#exportModal').modal('hide');
                        swal({
                            type: 'success',
                            title: '{{ trans('admin.global.success') }}',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
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

            // ─── PDF Export Modal Logic ─────────────────────────────────
            const $exportPdfGrade = $('#export-pdf-grade');
            const $exportPdfSection = $('#export-pdf-section');

            // Load sections on grade change for PDF modal
            $exportPdfGrade.on('change', function() {
                const gradeId = $(this).val();
                $exportPdfSection.val('').prop('disabled', true);

                if (!gradeId) return;

                $.ajax({
                    url: '{{ route('admin.get_sections_by_grade') }}',
                    type: 'GET',
                    data: {
                        grade_id: gradeId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $exportPdfSection.html(
                            '<option value="">{{ trans('admin.global.all') }}</option>'
                            );
                        if (response && response.success && response.data) {
                            $.each(response.data, function(id, name) {
                                $exportPdfSection.append(
                                    `<option value="${id}">${name}</option>`
                                );
                            });
                            $exportPdfSection.prop('disabled', false);
                        }
                    },
                    error: function() {
                        console.error('Failed to load sections');
                    }
                });
            });

            // Handle PDF export form submission
            $('#export-pdf-form').on('submit', function(e) {
                e.preventDefault();

                const $btn = $('#btn-submit-pdf-export');
                const originalText = $btn.html();

                $btn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}'
                );

                $.ajax({
                    url: '{{ route('admin.exports.attendance-pdf') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        academic_year_id: $('#export-pdf-academic-year').val(),
                        grade_id: $exportPdfGrade.val() || null,
                        section_id: $exportPdfSection.val() || null
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#exportPdfModal').modal('hide');
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
    });
</script>
