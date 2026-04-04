@extends('admin.layouts.master')

@section('title', trans('admin.graduations.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Students/graduations/graduations.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-success shadow-sm">
                        <i class="las la-graduation-cap"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.graduations.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.sidebar.users') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            <div class="mb-3 mb-xl-0 ml-2">
                <a class="btn btn-modern btn-primary shadow-sm" href="{{ route('admin.students.index') }}">
                    <i class="las la-arrow-left tx-16 mr-1 ml-1"></i>
                    {{ trans('admin.global.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            {{-- ─── Filter Section ─── --}}
            <div class="filter-section shadow-sm">
                <div class="row align-items-end">
                    {{-- Graduation Year Filter --}}
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-calendar-alt mr-1"></i>
                            {{ trans('admin.graduations.fields.graduation_year') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_graduation_year">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Spacer --}}
                    <div class="col-md-5"></div>

                    {{-- Reset Button --}}
                    <div class="col-md-3 text-right mt-3 mt-md-0">
                        <button class="btn btn-modern w-100" id="reset_filters">
                            <i class="las la-sync-alt mr-1 ml-1"></i>
                            {{ trans('admin.global.reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- ─── Glass Table Card ─── --}}
            <div class="card glass-card">
                <div class="card-header pb-0 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 d-flex align-items-center">
                            <span class="card-title-icon">
                                <i class="las la-graduation-cap tx-18"></i>
                            </span>
                            {{ trans('admin.graduations.list_title') }}
                        </h6>
                        <span class="alumni-count-badge" id="alumni_count">
                            <i class="las la-users mr-1"></i> <span id="total_count">0</span>
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="graduations_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-12p border-bottom-0">{{ trans('admin.students.fields.student_code') }}
                                    </th>
                                    <th class="wd-18p border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                                    <th class="wd-25p border-bottom-0">{{ trans('admin.graduations.fields.last_grade') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">
                                        {{ trans('admin.graduations.fields.graduation_year') }}</th>
                                    <th class="wd-12p border-bottom-0">{{ trans('admin.graduations.fields.graduated_at') }}
                                    </th>
                                    @can('restore_graduations')
                                        <th class="wd-13p border-bottom-0 text-center">{{ trans('admin.global.actions') }}</th>
                                    @endcan
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
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.min.js') }}"></script>
    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {
            // ─── DataTable Initialization ─────────────────────────────────────
            var table = $('#graduations_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang, {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">{{ trans('admin.global.loading') }}</span></div>'
                }),
                ajax: {
                    url: "{{ route('admin.graduations.index') }}",
                    data: function(d) {
                        d.filter_graduation_year = $('#filter_graduation_year').val();
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
                        name: 'student_code',
                        render: function(data) {
                            return '<span class="student-code-pill">' + (data || '—') + '</span>';
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'last_grade_details',
                        name: 'last_grade_details',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'graduation_year',
                        name: 'graduation_academic_year_id',
                        render: function(data) {
                            if (!data || data === '-') return '<span class="text-muted">—</span>';
                            return '<span class="graduation-badge"><i class="las la-calendar-check"></i>' +
                                data + '</span>';
                        }
                    },
                    {
                        data: 'graduated_at',
                        name: 'graduated_at',
                        render: function(data) {
                            if (!data || data === '-') return '<span class="text-muted">—</span>';
                            return '<span class="text-muted"><i class="las la-clock mr-1"></i>' +
                                data + '</span>';
                        }
                    },
                    @can('restore_graduations')
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    @endcan
                ],
                order: [
                    [5, 'desc']
                ],
                drawCallback: function(settings) {
                    var info = this.api().page.info();
                    $('#total_count').text(info.recordsTotal);
                },
            });

            // ─── Filter Changes ───────────────────────────────────────────────
            $('#filter_graduation_year').on('change', function() {
                table.draw();
            });

            // ─── Reset Filters ────────────────────────────────────────────────
            $('#reset_filters').on('click', function() {
                $('#filter_graduation_year').val('');
                table.draw();
            });

            // ─── Reload DataTable after restore completes ─────────────────────
            $(document).on('DOMNodeRemoved', '#graduations_table tbody tr', function() {
                setTimeout(function() {
                    table.ajax.reload(null, false);
                }, 600);
            });
        });
    </script>

    {{-- Include Restore Script --}}
    @include('admin.layouts.scripts.restore_script')
@endsection
