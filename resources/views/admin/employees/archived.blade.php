@extends('admin.layouts.master')

@section('title', __('admin.employees.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    {{-- Reuse Teacher Archive Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/archive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="teacher-archive-header d-flex justify-content-between align-items-center mt-4 mb-4">
        <div class="d-flex align-items-center">
            <div class="mr-3 ml-3">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="las la-trash-alt tx-24 text-white"></i>
                </div>
            </div>
            <div>
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.employees.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.employees.archived_list') ?? __('admin.global.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.employees.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
                <i class="las la-arrow-right mr-1 ml-1"></i> {{ __('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    {{-- ─── Warning Alert ─── --}}
    <div class="teacher-archive-alert shadow-sm">
        <div class="mr-3 ml-3" style="width:40px;height:40px;border-radius:50%;background:#fc8181;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="las la-exclamation-triangle text-white tx-20"></i>
        </div>
        <div>
            <h6 class="text-danger font-weight-bold mb-1">{{ trans('admin.employees.warning_title') ?? trans('admin.global.warning') }}</h6>
            <p class="text-muted mb-0 tx-13">{{ trans('admin.employees.warning_body') ?? trans('admin.global.archive_warning') }}</p>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card teacher-glass-card-archive">
                <div class="archive-table-card-header pb-0">
                    <div class="archive-table-title">
                        <span class="title-dot"></span>
                        {{ __('admin.employees.archived') }}
                        <span class="archive-count-badge" id="archive_count">{{ $archivedCount }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="employees_archive_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.employee_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.type') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.status') }}</th>
                                @canany(['restore_employees','force-delete_employees'])
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.global.actions') }}</th>
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

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            var table = $('#employees_archive_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.employees.archived') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'employee_code', name: 'employee_code' },
                    { data: 'type', name: 'type' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status_badge', name: 'status_badge', className: 'text-center' },
                    @canany(['restore_employees', 'force-delete_employees'])
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
                    @endcanany
                ]
            });
        });
    </script>
    @stack('scripts')
@endsection
