@extends('admin.layouts.master')

@section('title', trans('admin.Users.students.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    {{-- Krajee Bootstrap FileInput CSS --}}
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- Student CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/student/student-crud.css') }}" rel="stylesheet">
    {{-- Student Show Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/student/show.css') }}" rel="stylesheet">
    {{-- Student Finance Modal Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/student/finance.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-user-graduate"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.Users.students.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.sidebar.users') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('view-archived_students')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="btn btn-modern btn-danger shadow-sm" href="{{ route('admin.Users.students.archived') }}">
                        <i class="las la-archive tx-16 mr-1 ml-1"></i>
                        {{ trans('admin.Users.students.archived') }}
                    </a>
                </div>
            @endcan
            @can('create_students')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.Users.students.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            {{-- ─── Advanced Filter Section ─── --}}
            <div class="filter-section shadow-sm">
                <div class="row align-items-end">

                    {{-- Grade --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-layer-group mr-1"></i> {{ trans('admin.Users.students.fields.grade') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}" data-name="{{ $grade->name }}">{{ $grade->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Classroom --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-chalkboard mr-1"></i> {{ trans('admin.Users.students.fields.classroom') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_classroom" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Section --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-users mr-1"></i> {{ trans('admin.Users.students.fields.section') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_section" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-toggle-on mr-1"></i> {{ trans('admin.Users.students.fields.status') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_status">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            <option value="1">{{ trans('admin.global.active') }}</option>
                            <option value="0">{{ trans('admin.global.disabled') }}</option>
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

            {{-- ─── Glass Table Card ─── --}}
            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="students_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.Users.students.fields.student_code') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.Users.students.fields.name') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.Users.students.fields.guardian') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.Users.students.fields.grade') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.Users.students.fields.classroom') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.Users.students.fields.section') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">
                                        {{ trans('admin.Users.students.fields.status') }}</th>
                                    @canany(['view_students', 'edit_students', 'delete_students'])
                                        <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.global.actions') }}</th>
                                    @endcanany
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
    @include('admin.Users.students.add_modal')
    @include('admin.Users.students.edit_modal')
    @include('admin.Users.students.show_modal')

    {{-- Finance Modal Container (loaded via AJAX) --}}
    <div class="modal fade" id="financeModal" tabindex="-1" role="dialog" aria-labelledby="financeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" id="financeModalContent">
                {{-- Content loaded via AJAX --}}
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    <script>
        $(document).ready(function() {

            var table = $('#students_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: "{{ route('admin.Users.students.index') }}",
                    data: function(d) {
                        d.filter_grade = $('#filter_grade').val();
                        d.filter_classroom = $('#filter_classroom').val();
                        d.filter_section = $('#filter_section').val();
                        d.filter_status = $('#filter_status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student_code',
                        name: 'student_code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'guardian_name',
                        name: 'guardian.name_father'
                    },
                    {
                        data: 'grade_name',
                        name: 'grade_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'classroom_name',
                        name: 'classroom_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'section_name',
                        name: 'section_name',
                        defaultContent: '-'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    },
                    @canany(['edit_students', 'delete_students'])
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    @endcanany
                ],
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

            /* ─── Section & Status direct filter ─── */
            $('#filter_section, #filter_status').on('change', function() {
                table.draw();
            });

            /* ─── Reset all filters ─── */
            $('#reset_filters').on('click', function() {
                $('#filter_grade').val('').trigger('change');
                $('#filter_status').val('');
                table.draw();
            });

            /* ─── Finance Modal Handler ─── */
            $(document).on('click', '.finance-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                var url = btn.data('url');
                var $modal = $('#financeModal');
                var $content = $('#financeModalContent');

                // Show loading state
                $content.html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                    <p class="mt-3 text-muted">{{ trans('admin.Users.students.finance.loading') }}</p>
                </div>
            `);

                // Show modal
                $modal.modal('show');

                // Load content via AJAX
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $content.html(response);
                    },
                    error: function(xhr) {
                        $content.html(`
                        <div class="modal-body text-center py-5">
                            <div class="text-danger mb-3">
                                <i class="las la-exclamation-circle" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-danger">{{ trans('admin.global.error_title') }}</h5>
                            <p class="text-muted">{{ trans('admin.Users.students.finance.load_error') }}</p>
                            <button type="button" class="btn btn-secondary mt-3" data-dismiss="modal">
                                {{ trans('admin.global.close') }}
                            </button>
                        </div>
                    `);
                    }
                });
            });

            // Reset finance modal content when closed
            $('#financeModal').on('hidden.bs.modal', function() {
                $('#financeModalContent').html(`
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                    </div>
                </div>
            `);
            });

        });
    </script>
    @stack('scripts')
@endsection
