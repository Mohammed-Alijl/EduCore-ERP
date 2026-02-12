@extends('admin.layouts.master')

@section('title', __('admin.classrooms.title'))

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
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.classrooms.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_classrooms')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-warning-gradient btn-with-icon btn-block"
                       href="{{route('admin.classrooms.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{__('admin.classrooms.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_classrooms')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary-gradient btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ __('admin.classrooms.add') }}
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
                        <table class="table text-md-nowrap" id="classrooms_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.grade') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.classrooms.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.classrooms.fields.notes') }}</th>
                                @canany('edit_classrooms','delete_classrooms')
                                    <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classrooms as $classroom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->grade->name }}</td>
                                    <td>
                                        @if ($classroom->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $classroom->notes ?? __('admin.grades.no_notes') }}</td>
                                    @canany('edit_classrooms','delete_classrooms')
                                    <td>
                                        @if($classroom->grade->status)
                                        @can('edit_classrooms')
                                        <a class="btn btn-info btn-sm edit-btn"
                                        href="#"
                                           data-toggle="modal"
                                           data-target="#editModal"
                                           data-url="{{ route('admin.classrooms.update', $classroom->id) }}"
                                           data-name_ar="{{ $classroom->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $classroom->getTranslation('name', 'en') }}"
                                           data-notes="{{ $classroom->notes }}"
                                           data-status="{{ $classroom->status }}"
                                           data-sort_order="{{ $classroom->sort_order }}"
                                           data-grade_id="{{ $classroom->grade->id }}"
                                        >
                                            <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                        </a>
                                        @endcan
                                        @can('delete_classrooms')
                                            <a class="modal-effect btn btn-sm btn-danger delete-item"
                                               href="#"
                                               data-id="{{ $classroom->id }}"
                                               data-url="{{ route('admin.classrooms.destroy', $classroom->id) }}"
                                               data-name="{{ $classroom->name }}">
                                                <i class="las la-trash"></i> {{__('admin.global.archive')}}
                                            </a>
                                        @endcan
                                        @else
                                            <span class="text-muted"><i class="las la-lock"></i></span> {{__('admin.global.disabled')}}
                                        @endif
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

    @include('admin.classrooms.add_modal')
    @include('admin.classrooms.edit_modal')

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
            $('#classrooms_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
@endsection
