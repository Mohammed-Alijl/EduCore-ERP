@extends('admin.layouts.master')

@section('title', __('admin.students.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════
           ARCHIVED STUDENTS — Custom Styles
        ══════════════════════════════════════════ */

        .page-header-archive {
            background: linear-gradient(to right, #2c3e50, #e74c3c);
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        /* ─── Alert Banner ─── */
        .archive-alert {
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }


        /* ─── Glass Card ─── */
        .glass-card-archive {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f0f2f8;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: box-shadow 0.25s ease;
        }
        .glass-card-archive:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.09); }

        /* ─── Filter Section ─── */
        .filter-section-archive {
            background: linear-gradient(135deg, rgba(225,29,72,0.03), rgba(159,18,57,0.02));
            border: 1.5px dashed rgba(225, 29, 72, 0.2);
            border-radius: 14px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .filter-section-archive .filter-label {
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 1.2px;
            color: #b91c1c; margin-bottom: 0.6rem;
            display: flex; align-items: center; gap: 0.4rem;
        }
        .filter-section-archive .form-control-modern {
            border-radius: 9px; border: 1.5px solid #e3e6f0;
            font-size: 0.875rem; box-shadow: none; height: auto;
            padding: 0.5rem 0.85rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .filter-section-archive .form-control-modern:focus {
            border-color: #e11d48;
            box-shadow: 0 0 0 0.2rem rgba(225, 29, 72, 0.12);
        }

        /* ─── Table Card ─── */
        .archive-table-card-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f0f2f8;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;
        }
        .archive-table-title {
            font-size: 0.95rem; font-weight: 700; color: #1e293b;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .archive-table-title .title-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #e11d48; display: inline-block;
        }
        .archive-count-badge {
            background: rgba(225, 29, 72, 0.1);
            color: #be123c;
            border-radius: 20px; font-weight: 700; font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
        }

        /* ─── Modern Form Controls ─── */
        #archivedStudentsTable thead th {
            font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #94a3b8; padding: 0.9rem 1rem;
            border-bottom: 2px solid #f0f2f8 !important;
            border-top: none !important;
            background: #fafbff;
            white-space: nowrap;
        }
        #archivedStudentsTable tbody tr {
            transition: background 0.15s;
        }
        #archivedStudentsTable tbody tr:hover { background: #fdf2f4; }
        #archivedStudentsTable tbody td {
            vertical-align: middle; font-size: 0.875rem;
            padding: 0.8rem 1rem; color: #374151;
            border-bottom: 1px solid #f8f9fb !important;
        }

        /* ─── Student Code Badge ─── */
        .student-code-pill {
            background: rgba(225, 29, 72, 0.08);
            color: #be123c; border-radius: 8px; font-weight: 700;
            font-size: 0.78rem; padding: 0.25rem 0.65rem;
            letter-spacing: 0.5px; display: inline-block;
        }

        /* ─── Deleted At Badge ─── */
        .deleted-at-pill {
            background: #fef2f2; color: #991b1b;
            border-radius: 8px; font-size: 0.75rem;
            padding: 0.2rem 0.6rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 0.3rem;
        }

        /* ─── Action Buttons ─── */
        .btn-archive-restore {
            background: linear-gradient(135deg, #0ea573, #057a52);
            color: #fff; border: none; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600;
            padding: 0.35rem 0.85rem;
            box-shadow: 0 3px 8px rgba(14,165,115,0.25);
            transition: all 0.2s ease;
        }
        .btn-archive-restore:hover {
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(14,165,115,0.35);
        }
        .btn-archive-delete {
            background: linear-gradient(135deg, #e11d48, #9f1239);
            color: #fff; border: none; border-radius: 8px;
            font-size: 0.78rem; font-weight: 600;
            padding: 0.35rem 0.85rem;
            box-shadow: 0 3px 8px rgba(225,29,72,0.25);
            transition: all 0.2s ease;
        }
        .btn-archive-delete:hover {
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(225,29,72,0.4);
        }

        /* ─── Back Button ─── */
        .btn-back-active {
            background: linear-gradient(135deg, #4e73df, #224abe);
            color: #fff; border: none; border-radius: 10px;
            font-weight: 700; padding: 0.6rem 1.4rem;
            box-shadow: 0 4px 12px rgba(78,115,223,0.3);
            transition: all 0.22s ease;
            font-size: 0.875rem;
        }
        .btn-back-active:hover {
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(78,115,223,0.4);
        }
        .btn-reset-archive {
            border-radius: 10px; font-weight: 600;
            border: 1.5px solid #e3e6f0; color: #6c7a9c; background: #fff;
            font-size: 0.875rem; padding: 0.6rem 1.1rem;
            transition: all 0.2s;
        }
        .btn-reset-archive:hover { background: #f8f9fc; border-color: #e11d48; color: #e11d48; }

        /* ─── Dark Theme Overrides ─── */
        .dark-theme .archive-alert {
            background: rgba(231, 76, 60, 0.1);
            border-left-color: #e74c3c;
        }
        .dark-theme .page-header-archive {
            background: linear-gradient(to right, #1a252f, #922b21);
        }
        .dark-theme .btn-reset-archive {
            background: #1e212b;
            border-color: rgba(255,255,255,0.1);
            color: #8896b3;
        }
        .dark-theme .btn-reset-archive:hover {
            background: #242836;
            border-color: #e11d48;
            color: #e11d48;
        }
        .dark-theme .glass-card-archive {
            background: #1e212b;
            border-color: rgba(255,255,255,0.06);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .dark-theme .glass-card-archive:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.45); }
        .dark-theme .filter-section-archive {
            background: rgba(225,29,72,0.04);
            border-color: rgba(225,29,72,0.15);
        }
        .dark-theme .filter-section-archive .form-control-modern {
            background: #14161f; border-color: rgba(255,255,255,0.1); color: #e2e8f0;
        }
        .dark-theme .filter-section-archive .form-control-modern:focus {
            background: #14161f; border-color: #e11d48;
        }
        .dark-theme .archive-table-card-header { border-bottom-color: rgba(255,255,255,0.05); }
        .dark-theme .archive-table-title { color: #f1f5f9; }
        .dark-theme #archivedStudentsTable thead th {
            background: #14161f; color: #64748b;
            border-bottom-color: rgba(255,255,255,0.05) !important;
        }
        .dark-theme #archivedStudentsTable tbody tr:hover { background: rgba(225,29,72,0.05); }
        .dark-theme #archivedStudentsTable tbody td {
            color: #cbd5e1; border-bottom-color: rgba(255,255,255,0.04) !important;
        }
        .dark-theme .student-code-pill { background: rgba(225,29,72,0.12); }
        .dark-theme .deleted-at-pill { background: rgba(153,27,27,0.15); color: #fca5a5; }
        .dark-theme .dataTables_wrapper .dataTables_info,
        .dark-theme .dataTables_wrapper .dataTables_length label,
        .dark-theme .dataTables_wrapper .dataTables_filter label { color: #8896b3; }
        .dark-theme .dataTables_wrapper input, .dark-theme .dataTables_wrapper select {
            background: #14161f; border-color: rgba(255,255,255,0.1); color: #e2e8f0;
        }
        .dark-theme .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #8896b3 !important;
        }
        .dark-theme .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: rgba(225,29,72,0.15) !important; color: #e11d48 !important; border-color: transparent !important;
        }
        .dark-theme .btn-reset-archive {
            background: #1e212b; border-color: rgba(255,255,255,0.1); color: #8896b3;
        }
    </style>
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
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.students.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.students.title') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.students.index') }}" class="btn btn-light shadow-sm" style="border-radius:8px;font-weight:600;">
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
            <h6 class="text-danger font-weight-bold mb-1">{{ trans('admin.students.warning_title') }}</h6>
            <p class="text-muted mb-0 tx-13">{{ trans('admin.students.warning_body') }}</p>
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
                    {{ trans('admin.students.fields.grade') }}
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
                    {{ trans('admin.students.fields.classroom') }}
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
                {{ __('admin.students.archived') }}
                <span class="archive-count-badge" id="archive_count">—</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive px-3 pb-3" style="padding-top: 1rem;">
            <table class="table" id="archivedStudentsTable" style="width:100%">
                <thead>
                <tr>
                    <th class="border-bottom-0">#</th>
                    <th class="border-bottom-0">{{ trans('admin.students.fields.student_code') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.students.fields.grade') }}</th>
                    <th class="border-bottom-0">{{ trans('admin.students.fields.classroom') }}</th>
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
    @include('admin.students.show_modal')
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
                url: '{{ route("admin.students.archived") }}',
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

            $.get('{{ route("admin.classrooms.by-grade") }}', { grade_id: gradeId }, function (response) {
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
