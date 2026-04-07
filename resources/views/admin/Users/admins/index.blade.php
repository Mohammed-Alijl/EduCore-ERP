@extends('admin.layouts.master')

@section('title', __('admin.Users.admins.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    {{-- Admins Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/Users/admin/admin-crud.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.Users.admins.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pr-1 mb-3 mb-xl-0">
                @can('create_admins')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.Users.admins.add') }}
                    </a>
                </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card admin-glass-card">
                <div class="card-header pb-0 border-bottom-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="admins_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.Users.admins.fields.image') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.Users.admins.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.Users.admins.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.Users.admins.fields.status') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.Users.admins.fields.roles') }}</th>
                                @if(auth()->user()->canAny(['edit_admins', 'delete_admins']))
                                    <th class="wd-20p border-bottom-0">{{ __('admin.Users.admins.actions') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="align-content-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <img alt="avatar" class="avatar avatar-md brround bg-white" src="{{ $admin->image_url }}">
                                    </td>
                                    <td class="align-content-center">{{ $admin->name }}</td>
                                    <td class="align-content-center">{{ $admin->email }}</td>
                                    <td class="align-content-center">
                                        @if ($admin->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td class="align-content-center">
                                        @foreach ($admin->roles_name as $role)
                                            <span class="badge badge-primary">{{ $role }}</span>
                                        @endforeach
                                    </td>

                                    @if(auth()->user()->canAny(['edit_admins', 'delete_admins']))
                                        <td class="align-content-center">
                                            @if(! $admin->hasRole('Super Admin'))
                                                <div class="admin-actions-container">
                                                    @can('edit_admins')
                                                        <a class="btn-admin-edit edit-btn"
                                                           href="#"
                                                           data-toggle="modal"
                                                           data-target="#editModal"
                                                           data-url="{{ route('admin.Users.admins.update', $admin->id) }}"
                                                           data-id="{{ $admin->id }}"
                                                           data-name="{{ $admin->name }}"
                                                           data-email="{{ $admin->email }}"
                                                           data-status="{{ $admin->status }}"
                                                           data-roles='@json($admin->roles->pluck("name"))'
                                                           title="{{ __('admin.actions.edit') }}">
                                                            <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                                        </a>
                                                    @endcan

                                                    @can('delete_admins')
                                                        <a class="modal-effect btn-admin-delete delete-item"
                                                           href="#"
                                                           data-id="{{ $admin->id }}"
                                                           data-url="{{ route('admin.Users.admins.destroy', $admin->id) }}"
                                                           data-name="{{ $admin->name }}">
                                                            <i class="las la-trash"></i> {{__('admin.global.delete')}}
                                                        </a>
                                                    @endcan
                                                </div>
                                            @else
                                                <span class="text-muted"><i class="las la-lock"></i></span> {{__('admin.global.protected')}}
                                            @endif
                                        </td>
                                    @endif
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

    @include('admin.Users.admins.add_modal')
    @include('admin.Users.admins.edit_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            $('#admins_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
@endsection
