@extends('admin.layouts.master')

@section('title', trans('admin.online_classes.title'))

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto">
                    <i class="las la-video text-primary mg-r-5"></i>
                    {{ trans('admin.online_classes.title') }}
                </h4>
                <span class="text-muted mt-1 tx-13 mg-l-5">
                    / {{ trans('admin.online_classes.management') }}
                </span>
            </div>
        </div>
    </div>
@endsection

@section('content')

    {{-- ============================================ --}}
    {{-- 1. ADVANCED FILTER CARD                      --}}
    {{-- ============================================ --}}
    <div class="row row-sm mg-b-20">
        <div class="col-lg-12">
            <div class="card custom-card filter-card">
                <div class="card-header border-bottom-0 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="card-header-icon bg-primary-transparent rounded-circle me-3 p-2">
                            <i class="las la-filter text-primary tx-22"></i>
                        </div>
                        <div>
                            <h6 class="card-title mb-1 fw-bold">
                                {{ trans('admin.global.filters') }}
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <form id="filter-form">
                        <div class="row row-sm">
                            {{-- Academic Year --}}
                            <div class="col-lg col-md-6 col-sm-12 mg-b-10">
                                <label class="form-label tx-12 fw-semibold text-uppercase">
                                    {{ trans('admin.online_classes.academic_year') }}
                                </label>
                                <select id="academic_year_id" name="academic_year_id" class="form-control select2-filter">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($academic_years as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Grade --}}
                            <div class="col-lg col-md-6 col-sm-12 mg-b-10">
                                <label class="form-label tx-12 fw-semibold text-uppercase">
                                    {{ trans('admin.online_classes.grade') }}
                                </label>
                                <select id="grade_id" name="grade_id" class="form-control select2-filter">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Classroom --}}
                            <div class="col-lg col-md-6 col-sm-12 mg-b-10">
                                <label class="form-label tx-12 fw-semibold text-uppercase">
                                    {{ trans('admin.online_classes.classroom') }}
                                </label>
                                <select id="classroom_id" name="classroom_id" class="form-control select2-filter" disabled>
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Section --}}
                            <div class="col-lg col-md-6 col-sm-12 mg-b-10">
                                <label class="form-label tx-12 fw-semibold text-uppercase">
                                    {{ trans('admin.online_classes.section') }}
                                </label>
                                <select id="section_id" name="section_id" class="form-control select2-filter" disabled>
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            {{-- Teacher --}}
                            <div class="col-lg col-md-6 col-sm-12 mg-b-10">
                                <label class="form-label tx-12 fw-semibold text-uppercase">
                                    {{ trans('admin.online_classes.teacher') }}
                                </label>
                                <select id="teacher_id" name="teacher_id" class="form-control select2-filter">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Filter Actions --}}
                        <div class="row mg-t-15">
                            <div class="col-12 d-flex justify-content-end gap-2">
                                <button type="button" id="btn-reset" class="btn btn-outline-danger btn-sm ripple">
                                    <i class="las la-eraser me-1"></i> {{ trans('admin.global.reset_filters') }}
                                </button>
                                <button type="button" id="btn-filter" class="btn btn-primary btn-sm ripple">
                                    <i class="las la-search me-1"></i> {{ trans('admin.global.search') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- 2. DATATABLE CARD                            --}}
    {{-- ============================================ --}}
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card table-card">
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table id="online_classes_table"
                            class="table table-hover table-bordered text-md-nowrap mg-b-0 w-100">
                            <thead>
                                <tr>
                                    <th class="text-center wd-30">#</th>
                                    <th>{{ trans('admin.online_classes.academic_year') }}</th>
                                    <th>{{ trans('admin.online_classes.grade_info') }}</th>
                                    <th>{{ trans('admin.online_classes.teacher') }}</th>
                                    <th>{{ trans('admin.online_classes.subject') }}</th>
                                    <th>{{ trans('admin.online_classes.timing') }}</th>
                                    <th>{{ trans('admin.online_classes.integration') }}</th>
                                    <th class="text-center">{{ trans('admin.online_classes.join_link') }}</th>
                                    <th class="text-center">{{ trans('admin.online_classes.actions') }}</th>
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
    @include('admin.online_classes.show_modal')
    </div>
    </div>
    </div>
    </div>

@endsection

@section('js')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    <script>
        $(document).ready(function() {



            var table = $('#online_classes_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: '{{ route('admin.online_classes.datatable') }}',
                    data: function(d) {
                        d.academic_year_id = $('#academic_year_id').val();
                        d.grade_id = $('#grade_id').val();
                        d.classroom_id = $('#classroom_id').val();
                        d.section_id = $('#section_id').val();
                        d.teacher_id = $('#teacher_id').val();
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
                        data: 'academic_year',
                        name: 'academic_year',
                        render: function(data) {
                            return '<span class="badge badge-light px-2 py-1"><i class="las la-calendar me-1"></i>' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'grade_info',
                        name: 'grade_info',
                        orderable: false
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
                        data: 'timing',
                        name: 'timing'
                    },
                    {
                        data: 'integration',
                        name: 'integration',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'join_link',
                        name: 'join_link',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
                    [0, 'desc']
                ]
            });

            $('#btn-filter').on('click', function() {
                table.ajax.reload();
            });

            $('#btn-reset').on('click', function() {
                $('.select2-filter').val('').trigger('change');
                table.ajax.reload();
            });

            $('#grade_id').on('change', function() {
                var gradeId = $(this).val();
                var classroomSelect = $('#classroom_id');
                var sectionSelect = $('#section_id');

                classroomSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);
                sectionSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);

                if (gradeId) {
                    $.ajax({
                        url: "{{ route('admin.classrooms.by-grade') }}",
                        type: 'GET',
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

            $('#classroom_id').on('change', function() {
                var classroomId = $(this).val();
                var sectionSelect = $('#section_id');

                sectionSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>')
                    .prop('disabled', true);

                if (classroomId) {
                    $.ajax({
                        url: "{{ route('admin.sections.by-classroom') }}",
                        type: 'GET',
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

            $('#academic_year_id, #section_id, #teacher_id').on('change', function() {
                table.draw();
            });

            $(document).ajaxSuccess(function(event, xhr, settings) {
                if (settings.type === 'DELETE' && settings.url && settings.url.indexOf(
                        '/online_classes/') !== -1) {
                    table.ajax.reload(null, false);
                }
            });

        });
    </script>
    @stack('scripts')
@endsection
