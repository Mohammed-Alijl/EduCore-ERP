@extends('admin.layouts.master')

@section('title', __('admin.designations.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    {{-- Designation CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/designation/designation-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/designation/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.hr') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.designations.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_designations')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-with-icon btn-block" data-effect="effect-scale"
                        data-toggle="modal" href="#createDesignationModal">
                        <i class="fas fa-plus-circle"></i> {{ __('admin.designations.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card desig-glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="designations_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-18p border-bottom-0">{{ __('admin.designations.fields.name') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ __('admin.designations.fields.department') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">{{ __('admin.designations.fields.description') }}
                                    </th>
                                    <th class="wd-10p border-bottom-0 text-center">
                                        {{ __('admin.designations.fields.default_salary') }}</th>
                                    <th class="wd-8p border-bottom-0 text-center">
                                        {{ __('admin.designations.fields.can_teach') }}</th>
                                    <th class="wd-8p border-bottom-0 text-center">
                                        {{ __('admin.designations.fields.employees_count') }}</th>
                                    @canany(['edit_designations', 'delete_designations', 'view_designations'])
                                        <th class="wd-15p border-bottom-0 text-center">{{ __('admin.global.actions') }}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($designations as $designation)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="font-weight-bold">{{ $designation->name }}</td>
                                        <td>
                                            <span class="desig-department-badge">
                                                <i class="las la-building"></i>
                                                {{ $designation->department->name ?? '--' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="desig-description-cell d-inline-block">{{ $designation->description ?: __('admin.designations.no_description') }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($designation->default_salary)
                                                <span class="desig-salary-badge">
                                                    {{ number_format($designation->default_salary, 2) }}
                                                </span>
                                            @else
                                                <span class="text-muted">--</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($designation->can_teach)
                                                <span
                                                    class="desig-teach-badge badge-yes">{{ __('admin.global.yes') }}</span>
                                            @else
                                                <span class="desig-teach-badge badge-no">{{ __('admin.global.no') }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="desig-count-badge">
                                                <i class="las la-users"></i> {{ $designation->employees_count }}
                                            </span>
                                        </td>
                                        @canany(['edit_designations', 'delete_designations', 'view_designations'])
                                            <td class="text-center">
                                                @can('view_designations')
                                                    <a class="btn btn-outline-primary btn-sm desig-action-btn desig-show-btn"
                                                        href="#" data-toggle="modal" data-target="#showDesignationModal"
                                                        data-name="{{ $designation->name }}"
                                                        data-description="{{ $designation->description }}"
                                                        data-department_name="{{ $designation->department->name ?? '' }}"
                                                        data-default_salary="{{ $designation->default_salary }}"
                                                        data-can_teach="{{ $designation->can_teach }}"
                                                        data-employees_count="{{ $designation->employees_count }}"
                                                        title="{{ __('admin.designations.show') }}">
                                                        <i class="las la-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('edit_designations')
                                                    <a class="btn btn-outline-info btn-sm desig-action-btn edit-btn" href="#"
                                                        data-toggle="modal" data-target="#editDesignationModal"
                                                        data-url="{{ route('admin.designations.update', $designation->id) }}"
                                                        data-name="{{ $designation->name }}"
                                                        data-description="{{ $designation->description }}"
                                                        data-department_id="{{ $designation->department_id }}"
                                                        data-default_salary="{{ $designation->default_salary }}"
                                                        data-can_teach="{{ $designation->can_teach }}"
                                                        title="{{ __('admin.designations.edit') }}">
                                                        <i class="las la-pen"></i>
                                                    </a>
                                                @endcan
                                                @can('delete_designations')
                                                    <a class="modal-effect btn btn-outline-danger btn-sm desig-action-btn delete-item"
                                                        href="#" data-id="{{ $designation->id }}"
                                                        data-url="{{ route('admin.designations.destroy', $designation->id) }}"
                                                        data-name="{{ $designation->name }}"
                                                        title="{{ __('admin.designations.delete') }}">
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

    @include('admin.designations.create_modal')
    @include('admin.designations.edit_modal')
    @include('admin.designations.show_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            $('#designations_table').DataTable(globalTableConfig);
        });
    </script>
    @stack('scripts')
@endsection
