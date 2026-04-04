@extends('admin.layouts.master')

@section('title', trans('admin.employees.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

    <!-- Krajee Bootstrap FileInput CSS -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">

    <!--Internal telephoneInput css-->
    <link rel="stylesheet" href="{{URL::asset('assets/admin/plugins/telephoneinput/telephoneinput.css')}}">
    {{-- Reuse Teacher CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/teacher-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.hr') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.employees.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_employees')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-danger btn-with-icon btn-block"
                       href="{{route('admin.employees.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{trans('admin.employees.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_employees')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addEmployeeModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ trans('admin.employees.add') }}
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
            <div class="filter-section shadow-sm mb-3">
                <div class="row align-items-end">

                    {{-- Department --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-building mr-1"></i> {{ trans('admin.departments.title') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_department">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Designation --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-id-badge mr-1"></i> {{ trans('admin.designations.title') }}
                        </label>
                        <select class="form-control form-control-modern" id="filter_designation" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                            <i class="las la-toggle-on mr-1"></i> {{ trans('admin.employees.fields.status') }}
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
                            {{ trans('admin.global.reset_filters') ?? 'Reset Filters' }}
                        </button>
                    </div>

                </div>
            </div>

            <div class="card teacher-glass-card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="employees_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-5p border-bottom-0">{{ trans('admin.employees.fields.image') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.employee_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.designation') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.employees.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.employees.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.status') }}</th>
                                @canany(['edit_employees','delete_employees'])
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.global.actions') }}</th>
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

    @include('admin.employees.add_modal')
    @include('admin.employees.edit_modal')
    @include('admin.employees.show_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    <!--Internal  telephoneInput js-->
    <script src="{{URL::asset('assets/admin/plugins/telephoneinput/telephoneinput.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            var table = $('#employees_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.employees.index') }}",
                    data: function(d) {
                        d.filter_department = $('#filter_department').val();
                        d.filter_designation = $('#filter_designation').val();
                        d.filter_status = $('#filter_status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'employee_code_link', name: 'employee_code' },
                    { data: 'designation_name', name: 'designation_name' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status_badge', name: 'status_badge', className: 'text-center' },
                    @canany(['edit_employees', 'delete_employees'])
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-center' },
                    @endcanany
                ]
            });

            /* ─── Filters ─── */
            $('#filter_department').on('change', function() {
                let departmentId = $(this).val();
                let designationSelect = $('#filter_designation');
                
                designationSelect.empty().append('<option value="">{{ trans('admin.global.all') }}</option>').prop('disabled', true);
                
                if (departmentId) {
                    $.ajax({
                        url: "{{ route('admin.get_designations') }}",
                        data: { department_id: departmentId },
                        success: function(response) {
                            if (response.length > 0) {
                                $.each(response, function(index, item) {
                                    designationSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                                });
                                designationSelect.prop('disabled', false);
                            }
                        }
                    });
                }
                table.draw();
            });

            $('#filter_designation, #filter_status').on('change', function() { table.draw(); });

            $('#reset_filters').on('click', function() {
                $('#filter_department').val('').trigger('change');
                $('#filter_status').val('');
                table.draw();
            });

            $('.select2').select2({
                placeholder: '{{trans("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
