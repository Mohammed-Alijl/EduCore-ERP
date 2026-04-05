@extends('admin.layouts.master')

@section('title', __('admin.Academic.grades.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    {{-- Grade CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Academic/grade/archive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Academic/grade/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="page-header-archive d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center">
            <div class="mr-3 ml-3">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="las la-trash-alt tx-24 text-white"></i>
                </div>
            </div>
            <div>
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.Academic.grades.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.Academic.grades.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.Academic.grades.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
                <i class="las la-arrow-right mr-1 ml-1"></i> {{ __('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection
@section('content')
    <div class="archive-alert shadow-sm">
        <div class="mr-3 ml-3" style="width: 40px; height: 40px; border-radius: 50%; background: #fc8181; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <i class="las la-exclamation-triangle text-white tx-20"></i>
        </div>
        <div>
            <h6 class="text-danger font-weight-bold mb-1">{{ __('admin.global.warning_title') }}</h6>
            <p class="text-muted mb-0 tx-13">{!! __('admin.Academic.grades.warning_body') !!}</p>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="sections_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.Academic.grades.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.Academic.grades.fields.status') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.Academic.grades.fields.notes') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
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
                                    <td>{{ $grade->notes ?? __('admin.Academic.sections.no_notes') }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm view-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-name="{{ $grade->name }}"
                                           data-status="{{ $grade->status }}"
                                           data-status_text="{{ $grade->status ? __('admin.global.active') : __('admin.global.disabled') }}"
                                           data-notes="{{ $grade->notes ?? __('admin.Academic.grades.no_notes') }}"
                                           data-classrooms='{!! json_encode($grade->classrooms) !!}'
                                        >
                                            <i class="las la-eye"></i> {{__('admin.global.view')}}
                                        </a>
                                        @can('restore_grades')
                                            <a class="btn btn-info btn-sm restore-item"
                                                   href="#"
                                                   data-url="{{ route('admin.Academic.grades.restore', $grade->id) }}"
                                                   data-id="{{ $grade->id }}"
                                                   data-name="{{ $grade->name }}"
                                                >
                                                    <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                </a>
                                            @endcan
                                            @can('delete_sections')
                                                <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                   href="#"
                                                   data-id="{{ $grade->id }}"
                                                   data-url="{{ route('admin.Academic.grades.forceDelete', $grade->id) }}"
                                                   data-name="{{ $grade->name }}">
                                                    <i class="las la-trash"></i> {{__('admin.global.delete')}}
                                                </a>
                                            @endcan
                                        </td>
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
    
    @include('admin.Academic.grades.show_modal')
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            $('#sections_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
