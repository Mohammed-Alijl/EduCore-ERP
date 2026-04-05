@extends('admin.layouts.master')

@section('title', trans('admin.sidebar.teacher_assignments'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    {{-- Teacher Assignments Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/LMS/teacher_assignment/teacher-assignment-crud.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.teachers') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.sidebar.teacher_assignments') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale"
                        data-toggle="modal" href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.LMS.teacher_assignments.add') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            {{-- ─── Advanced Filter Section ─── --}}
            <div class="assignment-filter-section shadow-sm">
                <div class="row align-items-end">

                    {{-- Teacher --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-user-tie mr-1"></i> {{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_teacher">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($lookups['teachers'] as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Grade --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-layer-group mr-1"></i> {{ trans('admin.Academic.grades.title') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($lookups['grades'] as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Classroom --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-chalkboard mr-1"></i> {{ trans('admin.Academic.classrooms.title') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_classroom" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Section --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-users mr-1"></i> {{ trans('admin.Academic.sections.title') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_section" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Reset Button --}}
                    <div class="col-md-3 text-right mt-3 mt-md-0">
                        <button class="btn btn-modern w-100" id="reset_filters">
                            <i class="las la-sync-alt mr-1 ml-1"></i>
                            {{ trans('admin.global.reset_filters', [], null) ?? 'Reset Filters' }}
                        </button>
                    </div>

                </div>
            </div>

            <div class="card assignment-glass-card">
                <div class="card-header pb-0 border-bottom-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="assignments_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-20p border-bottom-0">
                                        {{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }}</th>
                                    <th class="wd-20p border-bottom-0">
                                        {{ trans('admin.LMS.teacher_assignments.fields.subject_id') }}</th>
                                    <th class="wd-25p border-bottom-0">
                                        {{ trans('admin.LMS.teacher_assignments.fields.section_id') }}</th>
                                    <th class="wd-15p border-bottom-0">
                                        {{ trans('admin.LMS.teacher_assignments.fields.academic_year') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('admin.global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    @include('admin.LMS.teacher_assignments.add_modal')
    @include('admin.LMS.teacher_assignments.edit_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            var table = $('#assignments_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.LMS.teacher_assignments.index') }}",
                    data: function(d) {
                        d.filter_teacher = $('#filter_teacher').val();
                        d.filter_grade = $('#filter_grade').val();
                        d.filter_classroom = $('#filter_classroom').val();
                        d.filter_section = $('#filter_section').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'teacher_name',
                        name: 'teacher.name'
                    },
                    {
                        data: 'subject_name',
                        name: 'subject.name'
                    },
                    {
                        data: 'section_info',
                        name: 'section_info',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'academic_year',
                        name: 'academic_year'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            /* ─── Teacher filter ─── */
            $('#filter_teacher').on('change', function() {
                table.draw();
            });

            /* ─── Grade filter → load classrooms ─── */
            $('#filter_grade').on('change', function() {
                let gradeId = $(this).val();
                let classroomSelect = $('#filter_classroom');
                let sectionSelect = $('#filter_section');

                classroomSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);
                sectionSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);

                if (gradeId) {
                    $.ajax({
                        url: "{{ route('admin.Academic.classrooms.by-grade') }}",
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
                table.draw();
            });

            /* ─── Classroom filter → load sections ─── */
            $('#filter_classroom').on('change', function() {
                let classroomId = $(this).val();
                let sectionSelect = $('#filter_section');

                sectionSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);

                if (classroomId) {
                    $.ajax({
                        url: "{{ route('admin.Academic.sections.by-classroom') }}",
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
                table.draw();
            });

            /* ─── Section direct filter ─── */
            $('#filter_section').on('change', function() {
                table.draw();
            });

            /* ─── Reset all filters ─── */
            $('#reset_filters').on('click', function() {
                $('#filter_teacher').val('');
                $('#filter_grade').val('').trigger('change');
                table.draw();
            });

        });
    </script>
    @stack('scripts')
@endsection
