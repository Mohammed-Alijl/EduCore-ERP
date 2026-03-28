@extends('admin.layouts.master')

@section('title', __('admin.departments.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    {{-- Department CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/department/department-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/department/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.hr') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.departments.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_department')
            <div class="mb-3 mb-xl-0 ml-2">
                <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#createModal">
                    <i class="fas fa-plus-circle"></i> {{ __('admin.departments.add') }}
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card dept-glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="departments_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-25p border-bottom-0">{{ __('admin.departments.fields.name') }}</th>
                                <th class="wd-30p border-bottom-0">{{ __('admin.departments.fields.description') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.departments.fields.employees_count') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.departments.fields.designations_count') }}</th>
                                @canany(['edit_department','delete_department','view_department'])
                                    <th class="wd-20p border-bottom-0 text-center">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $department)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold">{{ $department->name }}</td>
                                    <td>
                                        <span class="dept-description-cell d-inline-block">{{ $department->description ?: __('admin.departments.no_description') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="dept-count-badge badge-employees">
                                            <i class="las la-users"></i> {{ $department->employees_count }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="dept-count-badge badge-designations">
                                            <i class="las la-briefcase"></i> {{ $department->designations_count }}
                                        </span>
                                    </td>
                                    @canany(['edit_department','delete_department','view_department'])
                                    <td class="text-center">
                                        @can('view_department')
                                        <a class="btn btn-outline-primary btn-sm dept-action-btn show-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-name="{{ $department->name }}"
                                           data-description="{{ $department->description }}"
                                           data-employees_count="{{ $department->employees_count }}"
                                           data-designations_count="{{ $department->designations_count }}"
                                           data-designations="{{ json_encode($department->designations->map(fn($d) => ['name' => $d->name, 'employees_count' => $d->employees_count ?? 0])) }}"
                                           title="{{ __('admin.departments.show') }}">
                                            <i class="las la-eye"></i>
                                        </a>
                                        @endcan
                                        @can('edit_department')
                                        <a class="btn btn-outline-info btn-sm dept-action-btn edit-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#editModal"
                                           data-url="{{ route('admin.departments.update', $department->id) }}"
                                           data-name="{{ $department->name }}"
                                           data-description="{{ $department->description }}"
                                           title="{{ __('admin.departments.edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                        @endcan
                                        @can('delete_department')
                                            <a class="modal-effect btn btn-outline-danger btn-sm dept-action-btn delete-item"
                                               href="#"
                                               data-id="{{ $department->id }}"
                                               data-url="{{ route('admin.departments.destroy', $department->id) }}"
                                               data-name="{{ $department->name }}"
                                               title="{{ __('admin.departments.delete') }}">
                                                <i class="las la-trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                    @endcanany
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @include('admin.departments.create_modal')
    @include('admin.departments.edit_modal')
    @include('admin.departments.show_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            $('#departments_table').DataTable(globalTableConfig);
        });
    </script>
    @stack('scripts')
@endsection
