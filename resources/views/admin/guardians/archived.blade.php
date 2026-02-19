@extends('admin.layouts.master')

@section('title', __('admin.sections.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.guardians.title') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.guardians.archived') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="guardians_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.guardians.fields.email') }}</th>
                                <th>{{ __('admin.guardians.fields.name_father') }}</th>
                                <th>{{ __('admin.guardians.fields.national_id_father') }}</th>
                                <th>{{ __('admin.guardians.fields.phone_father') }}</th>
                                <th>{{ __('admin.guardians.fields.name_mother') }}</th>
                                @canany('restore_guardians','force-delete_guardians')
                                    <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($guardians as $guardian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guardian->email }}</td>
                                    <td>{{ $guardian->name_father }}</td>
                                    <td>{{ $guardian->national_id_father }}</td>
                                    <td>{{ $guardian->phone_father }}</td>
                                    <td>{{ $guardian->name_mother }}</td>
                                    @canany('restore_guardian','force-delete_guardian')
                                        <td>
                                            @can('restore_guardian')
                                                <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.guardians.restore', $guardian->id) }}"
                                                   data-id="{{ $guardian->id }}"
                                                   data-name="{{ $guardian->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('force-delete_guardian')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $guardian->id }}"
                                                   data-url="{{ route('admin.guardians.forceDelete', $guardian->id) }}"
                                                   data-name="{{ $guardian->name }}">
                                                    <i class="las la-trash"></i> {{__('admin.global.delete')}}
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

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            $('#guardians_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
@endsection
