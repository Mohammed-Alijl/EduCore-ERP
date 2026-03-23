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
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
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
                style: { fontWeight: 700, fontSize: '13px' }
            },
            xaxis: {
                categories: dayData.categories,
                labels: { style: { fontWeight: 600 } }
            },
            yaxis: {
                title: {
                    text: @json(trans('admin.reports.attendance.charts.absences_count')),
                    style: { fontWeight: 700 }
                }
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: { show: false },
            tooltip: { theme: isDark ? 'dark' : 'light' }
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
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            plotOptions: {
                pie: {
                    donut: { size: '65%' }
                }
            },
            colors: ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#f97316'],
            dataLabels: { enabled: false },
            legend: {
                position: 'bottom',
                offsetY: 0,
                fontSize: '13px',
                fontWeight: 600,
                markers: { radius: 12 }
            },
            stroke: { show: true, colors: [isDark ? '#1e2130' : '#ffffff'], width: 2 },
            tooltip: { theme: isDark ? 'dark' : 'light' }
        };
        const absencesGradeChart = new ApexCharts(document.querySelector('#absences-by-grade-chart'), gradeChartOptions);
        absencesGradeChart.render();

        // ─── DataTable ─────────────────────────────────────────────
        const attendanceTable = $('#attendance_report_table').DataTable(getTableConfig({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.reports.attendance.index") }}',
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
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'student_name', name: 'student_name' },
                { data: 'section_name', name: 'section_name' },
                { data: 'total_days', name: 'total_days', className: 'text-center' },
                { data: 'present_days', name: 'present_days', className: 'text-center' },
                { data: 'absent_days', name: 'absent_days', className: 'text-center' },
                { data: 'late_days', name: 'late_days', className: 'text-center' },
                { data: 'attendance_percentage', name: 'attendance_percentage', className: 'text-center' },
            ],
            order: [[7, 'asc']],
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
            const url = '{{ route("admin.reports.attendance.index") }}' + (queryString ? '?' + queryString : '');
            window.location.href = url;
        });

        // ─── Reset Filters ─────────────────────────────────────────
        $('#btn-reset-filters').on('click', function() {
            window.location.href = '{{ route("admin.reports.attendance.index") }}';
        });

        // ─── Animation Keyframes ───────────────────────────────────
        $('<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}</style>').appendTo('head');
    });
</script>
