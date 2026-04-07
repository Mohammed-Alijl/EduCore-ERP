@extends('admin.layouts.master')

@section('title', trans('admin.LMS.books.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <style>
        .library-hero-card,
        .library-filter-card,
        .library-table-card {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
        }

        .library-hero-card .card-body {
            padding: 22px;
        }

        .library-hero-title {
            font-weight: 700;
            letter-spacing: .2px;
            margin-bottom: .25rem;
        }

        .library-hero-subtitle {
            margin: 0;
            opacity: .85;
            font-size: 13px;
        }

        .library-filter-card .card-body {
            padding: 1.25rem;
        }

        .library-filter-card .form-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: .35rem;
            color: #6c757d;
        }

        .library-filter-card .select2-container {
            width: 100% !important;
        }

        .library-filter-card .select2-container--default .select2-selection--single {
            height: 40px;
            border-radius: 10px;
            border-color: #e5e9f2;
            display: flex;
            align-items: center;
            padding-inline-start: .35rem;
        }

        .library-filter-card .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }

        .library-filter-card .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: inherit;
        }

        .library-filter-actions {
            margin-top: 1rem;
            text-align: end;
        }

        .library-filter-actions .btn {
            min-width: 120px;
            border-radius: 10px;
        }

        .dark-theme .library-filter-card .select2-container--default .select2-selection--single,
        .dark-theme .library-filter-card .select2-container--default .select2-selection--multiple {
            background-color: #252f4a;
            border-color: #3b4665;
            color: #fff;
        }

        .dark-theme .library-filter-card .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #d9dff1;
        }

        .library-table-card .card-body {
            padding: 1.1rem;
        }

        .library-table-card table td,
        .library-table-card table th {
            vertical-align: middle;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto w-100">
            <div class="card library-hero-card bg-primary text-white shadow-sm mb-0">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h4 class="library-hero-title">{{ trans('admin.LMS.books.title') }}</h4>
                        <p class="library-hero-subtitle">{{ trans('admin.LMS.books.sub_title') }}</p>
                    </div>
                    <div class="text-white-50 mt-2 mt-md-0">
                        <i class="las la-book-open tx-40"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card library-filter-card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl col-lg-4 col-md-6 mb-3">
                            <label class="form-label">{{ trans('admin.LMS.books.form.select_grade') }}</label>
                            <select id="filter_grade" class="form-control select2-filter">
                                <option value="">{{ trans('admin.global.all') }}</option>
                                @foreach ($grades ?? [] as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl col-lg-4 col-md-6 mb-3">
                            <label class="form-label">{{ trans('admin.LMS.books.form.select_classroom') }}</label>
                            <select id="filter_classroom" class="form-control select2-filter" disabled>
                                <option value="">{{ trans('admin.global.all') }}</option>
                            </select>
                        </div>

                        <div class="col-xl col-lg-4 col-md-6 mb-3">
                            <label class="form-label">{{ trans('admin.LMS.books.form.select_section') }}</label>
                            <select id="filter_section" class="form-control select2-filter" disabled>
                                <option value="">{{ trans('admin.global.all') }}</option>
                            </select>
                        </div>

                        <div class="col-xl col-lg-4 col-md-6 mb-3">
                            <label class="form-label">{{ trans('admin.LMS.books.form.select_teacher') }}</label>
                            <select id="filter_teacher" class="form-control select2-filter">
                                <option value="">{{ trans('admin.global.all') }}</option>
                                @foreach ($teachers ?? [] as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl col-lg-4 col-md-6 mb-3">
                            <label class="form-label">{{ trans('admin.LMS.books.form.select_subject') }}</label>
                            <select id="filter_subject" class="form-control select2-filter">
                                <option value="">{{ trans('admin.global.all') }}</option>
                                @foreach ($subjects ?? [] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="library-filter-actions">
                        <button type="button" id="btn_search" class="btn btn-primary btn-sm mr-2 ml-2">
                            <i class="las la-search mr-1 ml-1"></i>
                            {{ trans('admin.global.search') }}
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-outline-secondary btn-sm">
                            <i class="las la-redo-alt mr-1 ml-1"></i>
                            {{ trans('admin.global.reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card library-table-card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="books_table" class="table text-md-nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('admin.LMS.books.table.title') }}</th>
                                    <th>{{ trans('admin.LMS.books.table.academic_target') }}</th>
                                    <th>{{ trans('admin.LMS.books.table.teacher') }}</th>
                                    <th>{{ trans('admin.LMS.books.table.subject') }}</th>
                                    <th>{{ trans('admin.LMS.books.table.actions') }}</th>
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
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>
    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(function() {
            const rtlMode = $('html').attr('dir') === 'rtl';

            $('.select2-filter').select2({
                width: '100%',
                dir: rtlMode ? 'rtl' : 'ltr',
                placeholder: "{{ trans('admin.global.select') }}"
            });

            const table = $('#books_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.library.datatable') }}",
                    data: function(d) {
                        d.grade_id = $('#filter_grade').val();
                        d.classroom_id = $('#filter_classroom').val();
                        d.section_id = $('#filter_section').val();
                        d.teacher_id = $('#filter_teacher').val();
                        d.subject_id = $('#filter_subject').val();
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
                        data: 'academic_target',
                        name: 'academic_target',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'teacher',
                        name: 'teacher'
                    },
                    {
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            const allText = "{{ trans('admin.global.all') }}";

            $('#filter_grade').on('change', function() {
                const gradeId = $(this).val();
                const classroomSelect = $('#filter_classroom');
                const sectionSelect = $('#filter_section');

                classroomSelect.html('<option value="">' + allText + '</option>').prop('disabled', true)
                    .trigger('change');
                sectionSelect.html('<option value="">' + allText + '</option>').prop('disabled', true)
                    .trigger('change');

                if (!gradeId) {
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                    type: 'GET',
                    data: {
                        grade_id: gradeId
                    },
                    success: function(response) {
                        if (response.success && Object.keys(response.data || {}).length) {
                            $.each(response.data, function(id, name) {
                                classroomSelect.append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                            classroomSelect.prop('disabled', false).trigger('change.select2');
                        }
                    }
                });
            });

            $('#filter_classroom').on('change', function() {
                const classroomId = $(this).val();
                const sectionSelect = $('#filter_section');

                sectionSelect.html('<option value="">' + allText + '</option>').prop('disabled', true)
                    .trigger('change');

                if (!classroomId) {
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.Academic.sections.by-classroom') }}",
                    type: 'GET',
                    data: {
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success && Object.keys(response.data || {}).length) {
                            $.each(response.data, function(id, name) {
                                sectionSelect.append('<option value="' + id + '">' +
                                    name + '</option>');
                            });
                            sectionSelect.prop('disabled', false).trigger('change.select2');
                        }
                    }
                });
            });

            $('#btn_search').on('click', function() {
                table.ajax.reload();
            });

            $('#btn_reset').on('click', function() {
                $('#filter_grade').val('').trigger('change');
                $('#filter_classroom').html('<option value="">' + allText + '</option>').prop('disabled',
                    true).trigger('change');
                $('#filter_section').html('<option value="">' + allText + '</option>').prop('disabled',
                    true).trigger('change');
                $('#filter_teacher').val('').trigger('change');
                $('#filter_subject').val('').trigger('change');
                table.ajax.reload();
            });
        });
    </script>
    @include('admin.layouts.scripts.delete_script')
@endsection
