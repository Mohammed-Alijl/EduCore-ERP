@extends('admin.layouts.master')
@section('title', __('admin.System.roles.title'))
@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    {{-- Roles Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/System/role/role.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.System.roles.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                @can('create_roles')
                    <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                       href="{{ route('admin.System.roles.create') }}">
                        <i class="fas fa-plus-circle"></i> {{ __('admin.System.roles.add') }}
                    </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card role-glass-card">
                <div class="role-form-header">
                    <div class="role-form-title">
                        <i class="las la-user-shield"></i>
                        {{ __('admin.System.roles.title') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="roles_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.System.roles.fields.name') }}</th>
                                <th>{{ __('admin.System.roles.fields.permissions_count') }}</th>
                                @canany(['view_roles', 'edit_roles', 'delete_roles'])
                                    <th>{{ __('admin.System.roles.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @can('view_roles')
                                            <a class="role-name-link btn-role-view modal-effect" 
                                               href="#roleShowModal" data-toggle="modal" data-effect="effect-scale"
                                               data-name="{{ $role->name }}"
                                               data-count="{{ $role->permissions_count }}"
                                               data-permissions="{{ $role->permissions->pluck('name') }}">
                                                <i class="las la-user-tag mr-1"></i>{{ $role->name }}
                                            </a>
                                        @else
                                            {{ $role->name }}
                                        @endcan
                                    </td>
                                    <td>
                                        <span class="badge-permissions">
                                            <i class="las la-key"></i>
                                            {{ $role->permissions_count }}
                                            {{ __('admin.System.roles.fields.permissions_count') }}
                                        </span>
                                    </td>
                                    @canany(['view_roles', 'edit_roles', 'delete_roles'])
                                        <td>
                                            <div class="role-actions-container">
                                                @if($role->name !== 'Super Admin')
                                                    @can('view_roles')
                                                        <a class="btn-role-view modal-effect" 
                                                           href="#roleShowModal" data-toggle="modal" data-effect="effect-scale"
                                                           data-name="{{ $role->name }}"
                                                           data-count="{{ $role->permissions_count }}"
                                                           data-permissions="{{ $role->permissions->pluck('name') }}">
                                                            <i class="las la-eye"></i> {{ __('admin.global.view') }}
                                                        </a>
                                                    @endcan
                                                    @can('edit_roles')
                                                        <a class="btn-role-edit" href="{{ route('admin.System.roles.edit', $role->id) }}">
                                                            <i class="las la-pen"></i> {{ __('admin.global.edit') }}
                                                        </a>
                                                    @endcan
                                                    @can('delete_roles')
                                                        <a class="btn-role-delete modal-effect delete-item"
                                                           href="#"
                                                           data-id="{{ $role->id }}"
                                                           data-url="{{ route('admin.System.roles.destroy', $role->id) }}"
                                                           data-name="{{ $role->name }}">
                                                            <i class="las la-trash"></i> {{ __('admin.global.delete') }}
                                                        </a>
                                                    @endcan
                                                @else
                                                    <span class="super-admin-lock">
                                                        <i class="las la-lock"></i> Super Admin
                                                    </span>
                                                @endif
                                            </div>
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

@endsection

@section('js')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.System.roles.show_modal')
    <script>
        $(document).ready(function() {
            $('#roles_table').DataTable(globalTableConfig);

            @if (session('status') === 'success')
            swal({
                title: '{{ __('admin.global.success') }}',
                text: '{{ session('message') }}',
                type: 'success',
                confirmButtonColor: '#4361ee',
                confirmButtonText: '{{ __('admin.global.ok') }}'
            });
            @endif

            @error('message')
            swal({
                title: '{{ __('admin.global.failed') }}',
                text: '{{ $message }}',
                type: 'error',
                confirmButtonColor: '#4361ee',
                confirmButtonText: '{{ __('admin.global.ok') }}'
            });
            @enderror
        });
    </script>
    @stack('scripts')
@endsection
