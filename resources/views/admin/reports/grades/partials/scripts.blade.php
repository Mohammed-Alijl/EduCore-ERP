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
            colors: ['#ef4444', '#f97316', '#f59e0b', '#6366f1', '#10b981'],
            dataLabels: {
                enabled: true,
                style: {
                    fontWeight: 700,
                    fontSize: '13px'
                }
            },
            xaxis: {
                categories: scoreDistData.labels,
                labels: {
                    style: {
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                title: {
                    text: @json(trans('admin.reports.grades.charts.students_count')),
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
                    borderRadius: 6,
                    horizontal: true,
                    barHeight: '60%',
                    distributed: true,
                }
            },
            colors: ['#6366f1', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b', '#ef4444', '#ec4899',
                '#f97316'
            ],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val + '%';
                },
                style: {
                    fontWeight: 700,
                    fontSize: '12px'
                }
            },
            xaxis: {
                max: 100,
                title: {
                    text: @json(trans('admin.reports.grades.charts.average_score')),
                    style: {
                        fontWeight: 700
                    }
                },
                labels: {
                    formatter: function(val) {
                        return val + '%';
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontWeight: 600,
                        fontSize: '11px'
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
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function(val) {
                        return val + '%';
                    }
                }
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
                    borderRadius: 6,
                    columnWidth: '55%',
                }
            },
            colors: ['#6366f1', '#10b981'],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val + '%';
                },
                style: {
                    fontWeight: 700,
                    fontSize: '11px'
                }
            },
            xaxis: {
                categories: gradeData.labels,
                labels: {
                    style: {
                        fontWeight: 600
                    }
                }
            },
            yaxis: {
                max: 100,
                title: {
                    text: '%',
                    style: {
                        fontWeight: 700
                    }
                },
                labels: {
                    formatter: function(val) {
                        return val + '%';
                    }
                }
            },
            grid: {
                borderColor: gridColor,
                strokeDashArray: 4
            },
            legend: {
                position: 'top',
                fontWeight: 600,
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light',
                y: {
                    formatter: function(val) {
                        return val + '%';
                    }
                }
            }
        });
        gradeChart.render();

        // ─── DataTable ─────────────────────────────────────────────
        const gradesTable = $('#grades_report_table').DataTable(getTableConfig({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.reports.grades.index') }}',
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
                    data: 'grade_name',
                    name: 'grade_name'
                },
                {
                    data: 'classroom_name',
                    name: 'classroom_name'
                },
                {
                    data: 'subject_name',
                    name: 'subject_name'
                },
                {
                    data: 'exam_title',
                    name: 'exam_title'
                },
                {
                    data: 'final_score',
                    name: 'final_score',
                    className: 'text-center'
                },
                {
                    data: 'percentage',
                    name: 'percentage',
                    className: 'text-center'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ],
            order: [
                [7, 'desc']
            ],
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
            const url = '{{ route('admin.reports.grades.index') }}' + (queryString ? '?' + queryString :
                '');
            window.location.href = url;
        });

        // ─── Reset Filters ─────────────────────────────────────────
        $('#btn-reset-filters').on('click', function() {
            window.location.href = '{{ route('admin.reports.grades.index') }}';
        });

        // ─── Smart Cascading Filters ───────
        function loadSubjects() {
            const gradeId = $('#filter-grade').val();
            const classroomId = $('#filter-classroom').val();
            const subjectSelect = $('#filter-subject');
            const currentSubjectId = subjectSelect.val();

            $.ajax({
                url: '{{ route('admin.reports.grades.subjects') }}',
                type: 'GET',
                data: {
                    grade_id: gradeId,
                    classroom_id: classroomId
                },
                success: function(response) {
                    if (response.success) {
                        subjectSelect.empty().append(
                            '<option value="">{{ trans('admin.reports.grades.filters.all_subjects') }}</option>'
                        );
                        $.each(response.data, function(id, name) {
                            subjectSelect.append('<option value="' + id + '"' + (id ==
                                    currentSubjectId ? ' selected' : '') + '>' + name +
                                '</option>');
                        });
                    }
                }
            });
        }

        function loadExams() {
            const academicYearId = $('#filter-academic-year').val();
            const gradeId = $('#filter-grade').val();
            const classroomId = $('#filter-classroom').val();
            const subjectId = $('#filter-subject').val();
            const examSelect = $('#filter-exam');
            const currentExamId = examSelect.val();

            $.ajax({
                url: '{{ route('admin.reports.grades.exams') }}',
                type: 'GET',
                data: {
                    academic_year_id: academicYearId,
                    grade_id: gradeId,
                    classroom_id: classroomId,
                    subject_id: subjectId
                },
                success: function(response) {
                    if (response.success) {
                        examSelect.empty().append(
                            '<option value="">{{ trans('admin.reports.grades.filters.all_exams') }}</option>'
                        );
                        $.each(response.data, function(id, title) {
                            examSelect.append('<option value="' + id + '"' + (id ==
                                    currentExamId ? ' selected' : '') + '>' + title +
                                '</option>');
                        });
                    }
                }
            });
        }

        $('#filter-academic-year').on('change', function() {
            loadExams();
        });

        $('#filter-subject').on('change', function() {
            loadExams();
        });

        $('#filter-grade').on('change', function() {
            const gradeId = $(this).val();
            const classroomSelect = $('#filter-classroom');
            const sectionSelect = $('#filter-section');

            classroomSelect.html(
                '<option value="">{{ trans('admin.reports.grades.filters.select_classroom') }}</option>'
            );
            sectionSelect.html(
                '<option value="">{{ trans('admin.reports.grades.filters.select_section') }}</option>'
            );

            if (gradeId) {
                $.ajax({
                    url: '{{ route('admin.classrooms.by-grade') }}',
                    type: 'GET',
                    data: {
                        grade_id: gradeId
                    },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(id, name) {
                                classroomSelect.append('<option value="' + id +
                                    '">' + name + '</option>');
                            });
                        }
                    }
                });
            }

            loadSubjects();
            loadExams();
        });

        $('#filter-classroom').on('change', function() {
            const classroomId = $(this).val();
            const sectionSelect = $('#filter-section');

            sectionSelect.html(
                '<option value="">{{ trans('admin.reports.grades.filters.select_section') }}</option>'
            );

            if (classroomId) {
                $.ajax({
                    url: '{{ route('admin.sections.by-classroom') }}',
                    type: 'GET',
                    data: {
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success) {
                            $.each(response.data, function(id, name) {
                                sectionSelect.append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                        }
                    }
                });
            }

            loadSubjects();
            loadExams();
        });

        // Initialize smart filters on page load to reflect current selections
        if ($('#filter-grade').val() || $('#filter-classroom').val()) {
            loadSubjects();
        }
        if ($('#filter-academic-year').val() || $('#filter-grade').val() || $('#filter-classroom').val() || $(
                '#filter-subject').val()) {
            loadExams();
        }

        // ─── Animation Keyframes ───────────────────────────────────
        $('<style>@keyframes fadeInUp{from{opacity:0;transform:translateY(15px);}to{opacity:1;transform:translateY(0);}}</style>')
            .appendTo('head');

        // ─── Export Functionality ──────────────────────────────────
        @can('export_grades-reports')
            // Excel Export Modal Logic
            function updateExportModalDropdowns() {
                // Copy values from main filters to export modal
                $('#export-academic-year').val($('#filter-academic-year').val());
                $('#export-grade').val($('#filter-grade').val());
                $('#export-classroom').val($('#filter-classroom').val());
                $('#export-section').val($('#filter-section').val());
                $('#export-subject').val($('#filter-subject').val());
                $('#export-exam').val($('#filter-exam').val());

                // Update options for cascading dropdowns
                loadExportClassroomOptions();
                loadExportSectionOptions();
                loadExportSubjectOptions();
                loadExportExamOptions();
            }

            function loadExportClassroomOptions() {
                const gradeId = $('#export-grade').val();
                const classroomSelect = $('#export-classroom');
                const currentClassroomId = classroomSelect.val();

                classroomSelect.html(
                    '<option value="">{{ trans('admin.reports.grades.filters.select_classroom') }}</option>'
                );

                if (gradeId) {
                    $.ajax({
                        url: '{{ route('admin.classrooms.by-grade') }}',
                        type: 'GET',
                        data: {
                            grade_id: gradeId
                        },
                        success: function(response) {
                            if (response.success) {
                                $.each(response.data, function(id, name) {
                                    classroomSelect.append('<option value="' + id + '"' + (
                                        id == currentClassroomId ? ' selected' : ''
                                    ) + '>' + name + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            function loadExportSectionOptions() {
                const classroomId = $('#export-classroom').val();
                const sectionSelect = $('#export-section');
                const currentSectionId = sectionSelect.val();

                sectionSelect.html(
                    '<option value="">{{ trans('admin.reports.grades.filters.select_section') }}</option>');

                if (classroomId) {
                    $.ajax({
                        url: '{{ route('admin.sections.by-classroom') }}',
                        type: 'GET',
                        data: {
                            classroom_id: classroomId
                        },
                        success: function(response) {
                            if (response.success) {
                                $.each(response.data, function(id, name) {
                                    sectionSelect.append('<option value="' + id + '"' + (
                                            id == currentSectionId ? ' selected' : '') +
                                        '>' + name + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            function loadExportSubjectOptions() {
                const gradeId = $('#export-grade').val();
                const classroomId = $('#export-classroom').val();
                const subjectSelect = $('#export-subject');
                const currentSubjectId = subjectSelect.val();

                $.ajax({
                    url: '{{ route('admin.reports.grades.subjects') }}',
                    type: 'GET',
                    data: {
                        grade_id: gradeId,
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success) {
                            subjectSelect.empty().append(
                                '<option value="">{{ trans('admin.reports.grades.filters.all_subjects') }}</option>'
                            );
                            $.each(response.data, function(id, name) {
                                subjectSelect.append('<option value="' + id + '"' + (id ==
                                        currentSubjectId ? ' selected' : '') + '>' +
                                    name + '</option>');
                            });
                        }
                    }
                });
            }

            function loadExportExamOptions() {
                const academicYearId = $('#export-academic-year').val();
                const gradeId = $('#export-grade').val();
                const classroomId = $('#export-classroom').val();
                const subjectId = $('#export-subject').val();
                const examSelect = $('#export-exam');
                const currentExamId = examSelect.val();

                $.ajax({
                    url: '{{ route('admin.reports.grades.exams') }}',
                    type: 'GET',
                    data: {
                        academic_year_id: academicYearId,
                        grade_id: gradeId,
                        classroom_id: classroomId,
                        subject_id: subjectId
                    },
                    success: function(response) {
                        if (response.success) {
                            examSelect.empty().append(
                                '<option value="">{{ trans('admin.reports.grades.filters.all_exams') }}</option>'
                            );
                            $.each(response.data, function(id, title) {
                                examSelect.append('<option value="' + id + '"' + (id ==
                                        currentExamId ? ' selected' : '') + '>' +
                                    title + '</option>');
                            });
                        }
                    }
                });
            }

            // Export modal cascading handlers
            $('#export-grade').on('change', function() {
                loadExportClassroomOptions();
                loadExportSubjectOptions();
                loadExportExamOptions();
            });

            $('#export-classroom').on('change', function() {
                loadExportSectionOptions();
                loadExportSubjectOptions();
                loadExportExamOptions();
            });

            $('#export-academic-year, #export-subject').on('change', function() {
                loadExportExamOptions();
            });

            // Show export modal
            $('#btn-export-excel').on('click', function() {
                updateExportModalDropdowns();
            });

            // Handle Excel export form submission
            $('#grades-export-form').on('submit', function(e) {
                e.preventDefault();

                const $btn = $('#btn-submit-export');
                const originalText = $btn.html();

                $btn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}'
                );

                $.ajax({
                    url: '{{ route('admin.exports.grades') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        academic_year_id: $('#export-academic-year').val() || null,
                        grade_id: $('#export-grade').val() || null,
                        classroom_id: $('#export-classroom').val() || null,
                        section_id: $('#export-section').val() || null,
                        subject_id: $('#export-subject').val() || null,
                        exam_id: $('#export-exam').val() || null
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#exportModal').modal('hide');
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

            // PDF Export Modal Logic
            function updatePdfExportModalDropdowns() {
                const academicYear = $('#filter-academic-year').val();
                if (academicYear) {
                    $('#export-pdf-academic-year').val(academicYear);
                }

                const grade = $('#filter-grade').val();
                if (grade) {
                    $('#export-pdf-grade').val(grade);
                }

                $('#export-pdf-classroom').val($('#filter-classroom').val());
                $('#export-pdf-section').val($('#filter-section').val());
                $('#export-pdf-subject').val($('#filter-subject').val());
                $('#export-pdf-exam').val($('#filter-exam').val());

                // Update options for cascading dropdowns
                loadPdfExportClassroomOptions();
                loadPdfExportSectionOptions();
                loadPdfExportSubjectOptions();
                loadPdfExportExamOptions();
            }

            function loadPdfExportClassroomOptions() {
                const gradeId = $('#export-pdf-grade').val();
                const classroomSelect = $('#export-pdf-classroom');
                const currentClassroomId = classroomSelect.val();

                classroomSelect.html(
                    '<option value="">{{ trans('admin.reports.grades.filters.select_classroom') }}</option>'
                );

                if (gradeId) {
                    $.ajax({
                        url: '{{ route('admin.classrooms.by-grade') }}',
                        type: 'GET',
                        data: {
                            grade_id: gradeId
                        },
                        success: function(response) {
                            if (response.success) {
                                $.each(response.data, function(id, name) {
                                    classroomSelect.append('<option value="' + id + '"' + (
                                        id == currentClassroomId ? ' selected' : ''
                                    ) + '>' + name + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            function loadPdfExportSectionOptions() {
                const classroomId = $('#export-pdf-classroom').val();
                const sectionSelect = $('#export-pdf-section');
                const currentSectionId = sectionSelect.val();

                sectionSelect.html(
                    '<option value="">{{ trans('admin.reports.grades.filters.select_section') }}</option>');

                if (classroomId) {
                    $.ajax({
                        url: '{{ route('admin.sections.by-classroom') }}',
                        type: 'GET',
                        data: {
                            classroom_id: classroomId
                        },
                        success: function(response) {
                            if (response.success) {
                                $.each(response.data, function(id, name) {
                                    sectionSelect.append('<option value="' + id + '"' + (
                                            id == currentSectionId ? ' selected' : '') +
                                        '>' + name + '</option>');
                                });
                            }
                        }
                    });
                }
            }

            function loadPdfExportSubjectOptions() {
                const gradeId = $('#export-pdf-grade').val();
                const classroomId = $('#export-pdf-classroom').val();
                const subjectSelect = $('#export-pdf-subject');
                const currentSubjectId = subjectSelect.val();

                $.ajax({
                    url: '{{ route('admin.reports.grades.subjects') }}',
                    type: 'GET',
                    data: {
                        grade_id: gradeId,
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success) {
                            subjectSelect.empty().append(
                                '<option value="">{{ trans('admin.reports.grades.filters.all_subjects') }}</option>'
                            );
                            $.each(response.data, function(id, name) {
                                subjectSelect.append('<option value="' + id + '"' + (id ==
                                        currentSubjectId ? ' selected' : '') + '>' +
                                    name + '</option>');
                            });
                        }
                    }
                });
            }

            function loadPdfExportExamOptions() {
                const academicYearId = $('#export-pdf-academic-year').val();
                const gradeId = $('#export-pdf-grade').val();
                const classroomId = $('#export-pdf-classroom').val();
                const subjectId = $('#export-pdf-subject').val();
                const examSelect = $('#export-pdf-exam');
                const currentExamId = examSelect.val();

                $.ajax({
                    url: '{{ route('admin.reports.grades.exams') }}',
                    type: 'GET',
                    data: {
                        academic_year_id: academicYearId,
                        grade_id: gradeId,
                        classroom_id: classroomId,
                        subject_id: subjectId
                    },
                    success: function(response) {
                        if (response.success) {
                            examSelect.empty().append(
                                '<option value="">{{ trans('admin.reports.grades.filters.all_exams') }}</option>'
                            );
                            $.each(response.data, function(id, title) {
                                examSelect.append('<option value="' + id + '"' + (id ==
                                        currentExamId ? ' selected' : '') + '>' +
                                    title + '</option>');
                            });
                        }
                    }
                });
            }

            // PDF export modal cascading handlers
            $('#export-pdf-grade').on('change', function() {
                loadPdfExportClassroomOptions();
                loadPdfExportSubjectOptions();
                loadPdfExportExamOptions();
            });

            $('#export-pdf-classroom').on('change', function() {
                loadPdfExportSectionOptions();
                loadPdfExportSubjectOptions();
                loadPdfExportExamOptions();
            });

            $('#export-pdf-academic-year, #export-pdf-subject').on('change', function() {
                loadPdfExportExamOptions();
            });

            // Show PDF export modal
            $('#btn-export-pdf').on('click', function() {
                updatePdfExportModalDropdowns();
            });

            // Handle PDF export form submission
            $('#grades-export-pdf-form').on('submit', function(e) {
                e.preventDefault();

                const $btn = $('#btn-submit-pdf-export');
                const originalText = $btn.html();

                $btn.prop('disabled', true).html(
                    '<i class="las la-spinner la-spin mr-1"></i> {{ trans('admin.global.loading') }}'
                );

                $.ajax({
                    url: '{{ route('admin.exports.grades-pdf') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        academic_year_id: $('#export-pdf-academic-year').val() || null,
                        grade_id: $('#export-pdf-grade').val() || null,
                        classroom_id: $('#export-pdf-classroom').val() || null,
                        section_id: $('#export-pdf-section').val() || null,
                        subject_id: $('#export-pdf-subject').val() || null,
                        exam_id: $('#export-pdf-exam').val() || null
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
