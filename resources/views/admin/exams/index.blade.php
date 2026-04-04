@extends('admin.layouts.master')

@section('title', trans('admin.exams.title'))

@section('css')
    {{-- DataTables CSS --}}
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- Select2 --}}
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    {{-- Exam CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Exams/exam/crud-exam.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between exam-page">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-file-alt"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.exams.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.exams.subtitle') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="exam-page">
        <div class="row row-sm">
            <div class="col-xl-12">

                {{-- ═══════════════════════════════════════════
                     Advanced Filters Card
                ═══════════════════════════════════════════ --}}
                <div class="glass-card mb-4">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-primary">
                                <i class="las la-filter"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ trans('admin.exams.filters.title') }}</h5>
                                <span>{{ trans('admin.exams.filters.subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="row">
                            {{-- Academic Year --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-calendar-alt"></i> {{ trans('admin.exams.filters.academic_year') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_academic_year"
                                    name="academic_year_id">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($academicYears as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Grade --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-layer-group"></i> {{ trans('admin.exams.filters.grade') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_grade" name="grade_id">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Classroom (Disabled Initially) --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-chalkboard"></i> {{ trans('admin.exams.filters.classroom') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_classroom"
                                    name="classroom_id" disabled>
                                    <option value="">{{ trans('admin.exams.filters.select_classroom') }}</option>
                                </select>
                            </div>

                            {{-- Section (Disabled Initially) --}}
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-users"></i> {{ trans('admin.exams.filters.section') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_section"
                                    name="section_id" disabled>
                                    <option value="">{{ trans('admin.exams.filters.select_section') }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- Filter Actions Footer --}}
                        <div class="filter-actions">
                            <button type="button" class="btn btn-filter-reset" id="btn_reset_filters">
                                <i class="las la-eraser mr-1 ml-1"></i>
                                {{ trans('admin.exams.filters.reset') }}
                            </button>
                            <button type="button" class="btn btn-filter-search" id="btn_filter_search">
                                <i class="las la-search mr-1 ml-1"></i>
                                {{ trans('admin.exams.filters.search') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                     DataTable Card
                ═══════════════════════════════════════════ --}}
                <div class="glass-card">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-info">
                                <i class="las la-table"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ trans('admin.exams.table.title') }}</h5>
                                <span>{{ trans('admin.exams.table.subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="exams_table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">#</th>
                                        <th class="wd-20p border-bottom-0">{{ trans('admin.exams.table.exam_title') }}</th>
                                        <th class="wd-10p border-bottom-0">{{ trans('admin.exams.table.academic_year') }}
                                        </th>
                                        <th class="wd-15p border-bottom-0">{{ trans('admin.exams.table.teacher') }}</th>
                                        <th class="wd-10p border-bottom-0">{{ trans('admin.exams.table.subject') }}</th>
                                        <th class="wd-15p border-bottom-0">{{ trans('admin.exams.table.time_window') }}
                                        </th>
                                        <th class="wd-10p border-bottom-0 text-center">
                                            {{ trans('admin.exams.table.status') }}</th>
                                        @can('view-student-attempts_exams')
                                            <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.global.actions') }}
                                            </th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {

            // ═══════════════════════════════════════════
            //  Select2 Initialization
            // ═══════════════════════════════════════════
            $('.select2').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder') || '';
                }
            });

            // ═══════════════════════════════════════════
            //  DataTable Initialization
            // ═══════════════════════════════════════════
            var examsTable = $('#exams_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: "{{ route('admin.exams.datatable') }}",
                    data: function(d) {
                        d.academic_year_id = $('#filter_academic_year').val();
                        d.grade_id = $('#filter_grade').val();
                        d.classroom_id = $('#filter_classroom').val();
                        d.section_id = $('#filter_section').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'academic_year',
                        name: 'academic_year',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'teacher',
                        name: 'teacher',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'time_window',
                        name: 'time_window',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    @can('view-student-attempts_exams')
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    @endcan
                ],
            });

            // ═══════════════════════════════════════════
            //  Filter Button → Reload Table
            // ═══════════════════════════════════════════
            $('#btn_filter_search').on('click', function() {
                examsTable.draw();
            });

            // ═══════════════════════════════════════════
            //  Grade → Load Classrooms (Cascade)
            // ═══════════════════════════════════════════
            $('#filter_grade').on('change', function() {
                var gradeId = $(this).val();
                var classroomSelect = $('#filter_classroom');
                var sectionSelect = $('#filter_section');

                // Reset downstream
                classroomSelect.empty().append(
                        '<option value="">{{ trans('admin.exams.filters.select_classroom') }}</option>')
                    .prop('disabled', true).trigger('change.select2');
                sectionSelect.empty().append(
                        '<option value="">{{ trans('admin.exams.filters.select_section') }}</option>')
                    .prop('disabled', true).trigger('change.select2');

                if (gradeId) {
                    $.ajax({
                        url: "{{ route('admin.classrooms.by-grade') }}",
                        data: {
                            grade_id: gradeId
                        },
                        success: function(response) {
                            if (response.success && Object.keys(response.data).length) {
                                $.each(response.data, function(id, name) {
                                    classroomSelect.append('<option value="' + id +
                                        '">' + name + '</option>');
                                });
                                classroomSelect.prop('disabled', false);
                            }
                        }
                    });
                }
            });

            // ═══════════════════════════════════════════
            //  Classroom → Load Sections (Cascade)
            // ═══════════════════════════════════════════
            $('#filter_classroom').on('change', function() {
                var classroomId = $(this).val();
                var sectionSelect = $('#filter_section');

                sectionSelect.empty().append(
                        '<option value="">{{ trans('admin.exams.filters.select_section') }}</option>')
                    .prop('disabled', true).trigger('change.select2');

                if (classroomId) {
                    $.ajax({
                        url: "{{ route('admin.sections.by-classroom') }}",
                        data: {
                            classroom_id: classroomId
                        },
                        success: function(response) {
                            if (response.success && Object.keys(response.data).length) {
                                $.each(response.data, function(id, name) {
                                    sectionSelect.append('<option value="' + id + '">' +
                                        name + '</option>');
                                });
                                sectionSelect.prop('disabled', false);
                            }
                        }
                    });
                }
            });

            // ═══════════════════════════════════════════
            //  Reset Filters
            // ═══════════════════════════════════════════
            $('#btn_reset_filters').on('click', function() {
                $('#filter_academic_year').val('').trigger('change');
                $('#filter_grade').val('').trigger('change');
                examsTable.draw();
            });

        });
    </script>
@endsection
