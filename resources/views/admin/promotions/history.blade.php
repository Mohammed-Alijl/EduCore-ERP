@extends('admin.layouts.master')

@section('title', trans('admin.promotions.history_title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .badge {
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-rollback:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-history"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.promotions.history_title') }}
                    </h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.sidebar.users') }} /
                        {{ trans('admin.promotions.title') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            <div class="mb-3 mb-xl-0 ml-2">
                <a class="btn btn-primary btn-modern shadow-sm" href="{{ route('admin.students.promotions.index') }}">
                    <i class="las la-arrow-left tx-16 mr-1 ml-1"></i>
                    {{ trans('admin.promotions.back_to_promotions') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            {{-- ─── Glass Table Card ─── --}}
            <div class="card glass-card">
                <div class="card-header pb-0 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-list-alt mr-2"></i>{{ trans('admin.promotions.history_list') }}
                        </h6>
                        <span class="badge badge-primary badge-pill">
                            <i class="fas fa-database mr-1"></i>{{ trans('admin.promotions.all_records') }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="promotion_history_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.student_code') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">
                                        {{ trans('admin.promotions.from_details') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">
                                        {{ trans('admin.promotions.to_details') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.promotions.status') }}
                                    </th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.promotions.admin') }}</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.promotions.date') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.global.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data will be loaded via DataTables AJAX --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {
            // ─── DataTable Initialization ─────────────────────────────────────
            var table = $('#promotion_history_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.students.promotions.history') }}",
                    type: "GET",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'student_code',
                        name: 'student.student_code'
                    },
                    {
                        data: 'student_name',
                        name: 'student.name'
                    },
                    {
                        data: 'from_details',
                        name: 'from_details',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'to_details',
                        name: 'to_details',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'enrollment_status',
                        name: 'enrollment_status',
                        className: 'text-center'
                    },
                    {
                        data: 'admin_name',
                        name: 'admin.name'
                    },
                    {
                        data: 'promotion_date',
                        name: 'created_at'
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
                    [7, 'desc']
                ], // Sort by date column (index 7) descending
                language: $.extend({}, datatable_lang, {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">{{ trans('admin.global.loading') }}</span></div>'
                })
            });

            // ─── Rollback Button Click Handler ────────────────────────────────
            $(document).on('click', '.btn-rollback', function(e) {
                e.preventDefault();

                const enrollmentId = $(this).data('id');
                const $button = $(this);

                Swal.fire({
                    title: '{{ trans('admin.promotions.rollback_confirm_title') }}',
                    html: '<p class="text-muted mb-0">{{ trans('admin.promotions.rollback_confirm_message') }}</p>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-undo mr-1"></i> {{ trans('admin.promotions.rollback_btn') }}',
                    cancelButtonText: '<i class="fas fa-times mr-1"></i> {{ trans('admin.global.cancel') }}',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger btn-lg shadow-sm mr-2',
                        cancelButton: 'btn btn-secondary btn-lg shadow-sm'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Disable button and show loading state
                        $button.prop('disabled', true);
                        $button.html(
                            '<span class="spinner-border spinner-border-sm mr-1"></span>{{ trans("admin.global.loading") }}'
                        );

                        // Send AJAX POST request
                        $.ajax({
                            url: '/admin/promotions/rollback/' + enrollmentId,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: '{{ trans('admin.global.success') }}',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#28a745',
                                        confirmButtonText: '<i class="fas fa-check mr-1"></i> {{ trans('admin.global.ok') }}',
                                        customClass: {
                                            confirmButton: 'btn btn-success btn-lg shadow-sm'
                                        },
                                        buttonsStyling: false
                                    }).then(function() {
                                        // Reload the DataTable
                                        table.ajax.reload(null, false);
                                    });
                                } else {
                                    showErrorAlert(response.message);
                                    $button.prop('disabled', false);
                                    $button.html(
                                        '<i class="fas fa-undo mr-1"></i>{{ trans("admin.promotions.rollback_btn") }}');
                                }
                            },
                            error: function(xhr) {
                                const response = xhr.responseJSON;
                                const message = (response && response.message) ?
                                    response.message :
                                    '{{ trans('admin.promotions.messages.failed.rollback') }}';

                                showErrorAlert(message);

                                // Re-enable button
                                $button.prop('disabled', false);
                                $button.html(
                                    '<i class="fas fa-undo mr-1"></i>{{ trans("admin.promotions.rollback_btn") }}');
                            }
                        });
                    }
                });
            });

            // ─── Helper Function: Show Error Alert ────────────────────────────
            function showErrorAlert(message) {
                Swal.fire({
                    title: '{{ trans('admin.global.error') }}',
                    text: message,
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: '<i class="fas fa-times mr-1"></i> {{ trans('admin.global.close') }}',
                    customClass: {
                        confirmButton: 'btn btn-danger btn-lg shadow-sm'
                    },
                    buttonsStyling: false
                });
            }
        });
    </script>
@endsection
