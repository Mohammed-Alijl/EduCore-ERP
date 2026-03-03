@extends('admin.layouts.master')

@section('title', __('admin.grades.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.academic_structure') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.grades.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('view-archived_grades')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="btn btn-modern btn-danger shadow-sm"
                       href="{{ route('admin.grades.archived') }}">
                        <i class="las la-archive tx-16 mr-1 ml-1"></i>
                        {{ trans('admin.grades.archived') }}
                    </a>
                </div>
            @endcan
            @can('create_grades')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.grades.add') }}
                    </a>
                </div>
            @endcan
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
                        <table class="table text-md-nowrap" id="admins_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.grades.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.grades.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.grades.fields.notes') }}</th>
                                @if(auth()->user()->canAny(['edit_grades', 'delete_grades']))
                                    <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $grade->name }}</td>
                                    <td>
                                        @if ($grade->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $grade->notes ?? __('admin.grades.no_notes') }}</td>
                                    @canany(['edit_grades','delete_grades'])
                                    <td>
                                        @can('edit_grades')
                                        <a class="btn btn-info btn-sm edit-btn"
                                        href="#"
                                           data-toggle="modal"
                                           data-target="#editModal"
                                           data-url="{{ route('admin.grades.update', $grade->id) }}"
                                           data-name_ar="{{ $grade->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $grade->getTranslation('name', 'en') }}"
                                           data-notes="{{ $grade->notes }}"
                                           data-status="{{ $grade->status }}"
                                           data-sort_order="{{ $grade->sort_order }}"
                                        >
                                            <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                        </a>
                                        @endcan
                                        @can('delete_grades')
                                            <a class="modal-effect btn btn-sm btn-danger delete-item"
                                               href="#"
                                               data-id="{{ $grade->id }}"
                                               data-url="{{ route('admin.grades.destroy', $grade->id) }}"
                                               data-name="{{ $grade->name }}">
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

    @include('admin.grades.add_modal')
    @include('admin.grades.edit_modal')

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
