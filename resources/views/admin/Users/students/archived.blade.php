@extends('admin.layouts.master')

@section('title', __('admin.Users.students.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    {{-- Archive Student Page --}}
    <link href="{{ URL::asset('assets/admin/css/Users/student/archive.css') }}" rel="stylesheet">
    {{-- Student Show Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/student/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="page-header-archive d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center">
            <div class="mr-3 ml-3">
                <div style="width:50px;height:50px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="las la-trash-alt tx-24 text-white"></i>
                </div>
            </div>
            <div>
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.Users.students.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.Users.students.title') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.Users.students.index') }}" class="btn btn-light shadow-sm" style="border-radius:8px;font-weight:600;">
                <i class="las la-arrow-left mr-1 ml-1"></i> {{ trans('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')

    <div class="archive-alert shadow-sm">
        <div class="mr-3 ml-3" style="width:40px;height:40px;border-radius:50%;background:#fc8181;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="las la-exclamation-triangle text-white tx-20"></i>
        </div>
        <div>
            <h6 class="text-danger font-weight-bold mb-1">{{ trans('admin.Users.students.warning_title') }}</h6>
            <p class="text-muted mb-0 tx-13">{{ trans('admin.Users.students.warning_body') }}</p>
        </div>
    </div>

    {{-- ─── FILTER SECTION ─── --}}
    <div class="filter-section-archive">
        <div class="filter-label">
            <i class="las la-filter"></i>
            {{ trans('admin.global.actions') }}
        </div>
        <div class="row align-items-end">
            <div class="col-md-4 mb-2 mb-md-0">
                <label class="tx-12 font-weight-600 text-muted mb-1">
                    {{ trans('admin.Users.students.fields.grade') }}
                </label>
                <select id="archive_filter_grade" class="form-control form-control-modern">
                    <option value="">— {{ trans('admin.global.all') }} —</option>
                    @foreach($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-2 mb-md-0">
                <label class="tx-12 font-weight-600 text-muted mb-1">
                    {{ trans('admin.Users.students.fields.classroom') }}
                </label>
                <select id="archive_filter_classroom" class="form-control form-control-modern" disabled>
                    <option value="">— {{ trans('admin.global.all') }} —</option>
                </select>
            </div>

            <div class="col-md-4">
                <button id="archive_reset_filters" class="btn btn-reset-archive w-100">
                    <i class="las la-redo-alt mr-1 ml-1"></i>
                    {{ trans('admin.global.reset_filters') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ─── TABLE CARD ─── --}}
    <div class="glass-card-archive">

        {{-- Card Header --}}
        <div class="archive-table-card-header">
            <div class="archive-table-title">
                <span class="title-dot"></span>
                {{ __('admin.Users.students.archived') }}
                <span class="archive-count-badge" id="archive_count">—</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive px-3 pb-3" style="padding-top: 1rem;">
            <table class="table" id="archivedStudentsTable" style="width:100%">
                <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{ trans('admin.Users.students.fields.student_code') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.Users.students.fields.name') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.Users.students.fields.grade') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.Users.students.fields.classroom') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.global.deleted') ?? 'Deleted At' }}</th>
                    @canany(['view-archived_students', 'restore_students', 'force-delete_students'])
                        <th class="border-bottom-0">{{ trans('admin.global.actions') }}</th>
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

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.Users.students.show_modal')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
    $(function () {

        /* ═══════════════════════════════════════
           DATATABLE — Archived Students
        ═══════════════════════════════════════ */
        var archiveTable = $('#archivedStudentsTable').DataTable({
            ...globalTableConfig, 
            processing: true,
            serverSide: true,
            language: $.extend({}, datatable_lang),
            ajax: {
                url: '{{ route("admin.Users.students.archived") }}',
                data: function (d) {
                    d.filter_grade      = $('#archive_filter_grade').val();
                    d.filter_classroom  = $('#archive_filter_classroom').val();
                },
            },
            columns: [
            { data: 'DT_RowIndex',     name: 'DT_RowIndex',   orderable: false, searchable: false },
            {
                data: 'student_code',
                name: 'student_code',
                searchable: false,
                render: function(data) {
                    return '<span class="student-code-pill">' + (data || '—') + '</span>';
                }
            },
            { data: 'name',          name: 'name',           searchable: false },
            { data: 'grade_name',    name: 'grade_name',     orderable: false, searchable: false },
            { data: 'classroom_name',name: 'classroom_name', orderable: false, searchable: false },
            {
                data: 'deleted_at',
                name: 'deleted_at',
                searchable: false,
                render: function(data) {
                    if (!data || data === '—') return '<span class="text-muted">—</span>';
                    return '<span class="deleted-at-pill"><i class="las la-clock"></i>' + data + '</span>';
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
        order: [[5, 'desc']],
        drawCallback: function(settings) {
            var info = this.api().page.info();
            $('#archive_count').text(info.recordsTotal);
        },
    });
        /* ═══════════════════════════════════════
           FILTER — Grade → Classroom cascade
        ═══════════════════════════════════════ */
        $('#archive_filter_grade').on('change', function () {
            var gradeId = $(this).val();
            var $classroom = $('#archive_filter_classroom');

            $classroom.prop('disabled', true).html('<option value="">— {{ trans("admin.global.all") }} —</option>');

            if (!gradeId) {
                archiveTable.ajax.reload();
                return;
            }

            $.get('{{ route("admin.Academic.classrooms.by-grade") }}', { grade_id: gradeId }, function (response) {
                if (response.success) {
                    $.each(response.data, function (id, name) {
                        $classroom.append('<option value="' + id + '">' + name + '</option>');
                    });
                    $classroom.prop('disabled', false);
                }
            });

            archiveTable.ajax.reload();
        });

        $('#archive_filter_classroom').on('change', function () {
            archiveTable.ajax.reload();
        });

        /* ─── Reset ─── */
        $('#archive_reset_filters').on('click', function () {
            $('#archive_filter_grade').val('');
            $('#archive_filter_classroom')
                .prop('disabled', true)
                .html('<option value="">— {{ trans("admin.global.all") }} —</option>');
            archiveTable.ajax.reload();
        });

        /* ─── After restore/delete, reload table ─── */
        $(document).on('restored deleted', function () {
            archiveTable.ajax.reload(null, false);
        });

    });
    </script>
    @stack('scripts')
@endsection
