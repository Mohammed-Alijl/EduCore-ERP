<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(function() {
        // ─── Chart Theme ───────────────────────────────────────────
        const isDark = $('body').hasClass('dark-theme');
        const chartTheme = {
            foreColor: isDark ? '#94a3b8' : '#64748b',
            background: 'transparent',
        };
        const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';

        // ─── Score Distribution Chart (Bar) ────────────────────────
        const scoreDistData = @json($chartData['scoreDistribution']);
        const scoreDistChart = new ApexCharts(document.querySelector('#score-distribution-chart'), {
            series: [{
                name: @json(trans('admin.reports.grades.charts.students_count')),
                data: scoreDistData.values
            }],
            chart: {
                type: 'bar',
                height: 300,
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
            colors: ['#ef4444', '#f97316', '#f59e0b', '#6366f1', '#10b981'],
            dataLabels: {
                enabled: true,
                style: { fontWeight: 700, fontSize: '13px' }
            },
            xaxis: {
                categories: scoreDistData.labels,
                labels: { style: { fontWeight: 600 } }
            },
            yaxis: {
                title: { text: @json(trans('admin.reports.grades.charts.students_count')), style: { fontWeight: 700 } }
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: { show: false },
            tooltip: { theme: isDark ? 'dark' : 'light' }
        });
        scoreDistChart.render();

        // ─── Subject Performance Chart (Bar) ───────────────────────
        const subjectData = @json($chartData['subjectPerformance']);
        const subjectChart = new ApexCharts(document.querySelector('#subject-performance-chart'), {
            series: [{
                name: @json(trans('admin.reports.grades.charts.average_score')),
                data: subjectData.values
            }],
            chart: {
                type: 'bar',
                height: 300,
                background: chartTheme.background,
                foreColor: chartTheme.foreColor,
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    horizontal: true,
                    barHeight: '60%',
                    distributed: true,
                }
            },
            colors: ['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444', '#ec4899', '#f97316'],
            dataLabels: {
                enabled: true,
                formatter: function(val) { return val + '%'; },
                style: { fontWeight: 700, fontSize: '12px' }
            },
            xaxis: {
                max: 100,
                title: { text: @json(trans('admin.reports.grades.charts.average_score')), style: { fontWeight: 700 } },
                labels: { formatter: function(val) { return val + '%'; } }
            },
            yaxis: {
                labels: { style: { fontWeight: 600, fontSize: '11px' } }
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: { show: false },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: function(val) { return val + '%'; } }
            }
        });
        subjectChart.render();

        // ─── Grade Comparison Chart (Grouped Bar) ──────────────────
        const gradeData = @json($chartData['gradeComparison']);
        const gradeChart = new ApexCharts(document.querySelector('#grade-comparison-chart'), {
            series: [{
                name: @json(trans('admin.reports.grades.charts.average_score')),
                data: gradeData.averages
            }, {
                name: @json(trans('admin.reports.grades.charts.pass_rate')),
                data: gradeData.passRates
            }],
            chart: {
                type: 'bar',
                height: 300,
                background: chartTheme.background,
                foreColor: chartTheme.foreColor,
                toolbar: { show: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%',
                }
            },
            colors: ['#6366f1', '#10b981'],
            dataLabels: {
                enabled: true,
                formatter: function(val) { return val + '%'; },
                style: { fontWeight: 700, fontSize: '11px' }
            },
            xaxis: {
                categories: gradeData.labels,
                labels: { style: { fontWeight: 600 } }
            },
            yaxis: {
                max: 100,
                title: { text: '%', style: { fontWeight: 700 } },
                labels: { formatter: function(val) { return val + '%'; } }
            },
            grid: { borderColor: gridColor, strokeDashArray: 4 },
            legend: {
                position: 'top',
                fontWeight: 600,
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: { formatter: function(val) { return val + '%'; } }
            }
        });
        gradeChart.render();

        // ─── DataTable ─────────────────────────────────────────────
        const gradesTable = $('#grades_report_table').DataTable(getTableConfig({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.reports.grades.index") }}',
                data: function(d) {
                    d.academic_year_id = $('#filter-academic-year').val();
                    d.grade_id = $('#filter-grade').val();
                    d.classroom_id = $('#filter-classroom').val();
                    d.section_id = $('#filter-section').val();
                    d.subject_id = $('#filter-subject').val();
                    d.exam_id = $('#filter-exam').val();
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
                { data: 'grade_name', name: 'grade_name' },
                { data: 'classroom_name', name: 'classroom_name' },
                { data: 'subject_name', name: 'subject_name' },
                { data: 'exam_title', name: 'exam_title' },
                { data: 'final_score', name: 'final_score', className: 'text-center' },
                { data: 'percentage', name: 'percentage', className: 'text-center' },
                { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
            ],
            order: [[7, 'desc']],
            drawCallback: function() {
                $('#grades_report_table tbody tr').each(function(index) {
                    $(this).css('animation', 'fadeInUp 0.3s ease forwards');
                    $(this).css('animation-delay', (index * 0.03) + 's');
                    $(this).css('opacity', '0');
                });
            }
        }));

        // ─── Filter Form Submit ────────────────────────────────────
        $('#grades-filter-form').on('submit', function(e) {
            e.preventDefault();
            // Reload table
            gradesTable.ajax.reload();
            // Reload page for chart/KPI updates
            const params = new URLSearchParams($(this).serialize());
            // Remove empty params
            Array.from(params.entries()).forEach(([key, value]) => {
                if (!value) params.delete(key);
            });
            const queryString = params.toString();
            const url = '{{ route("admin.reports.grades.index") }}' + (queryString ? '?' + queryString : '');
            window.location.href = url;
        });

        // ─── Reset Filters ─────────────────────────────────────────
        $('#btn-reset-filters').on('click', function() {
            window.location.href = '{{ route("admin.reports.grades.index") }}';
        });

        // ─── Cascading Filters: Grade → Classroom → Section ───────
        $('#filter-grade').on('change', function() {
            const gradeId = $(this).val();
            const classroomSelect = $('#filter-classroom');
            const sectionSelect = $('#filter-section');

            classroomSelect.html('<option value="">{{ trans("admin.reports.grades.filters.select_classroom") }}</option>');
            sectionSelect.html('<option value="">{{ trans("admin.reports.grades.filters.select_section") }}</option>');

            if (gradeId) {
                $.ajax({
                    url: '{{ route("admin.classrooms.by-grade") }}',
                    type: 'GET',
                    data: { grade_id: gradeId },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(id, name) {
                                classroomSelect.append('<option value="' + id + '">' + name + '</option>');
                            });
                        }
                    }
                });
            }
        });

        $('#filter-classroom').on('change', function() {
            const classroomId = $(this).val();
            const sectionSelect = $('#filter-section');

            sectionSelect.html('<option value="">{{ trans("admin.reports.grades.filters.select_section") }}</option>');

            if (classroomId) {
                $.ajax({
                    url: '{{ route("admin.sections.by-classroom") }}',
                    type: 'GET',
                    data: { classroom_id: classroomId },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(id, name) {
                                sectionSelect.append('<option value="' + id + '">' + name + '</option>');
                            });
                        }
                    }
                });
            }
        });

        // ─── Animation Keyframes ───────────────────────────────────
        $('<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}</style>').appendTo('head');
    });
</script>
