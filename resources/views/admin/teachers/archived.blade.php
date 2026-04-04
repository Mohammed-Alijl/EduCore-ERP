@extends('admin.layouts.master')

@section('title', __('admin.teachers.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    {{-- Teacher Archive Styles --}}
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
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.teachers.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.teachers.archived_list') ?? __('admin.global.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
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
            <h6 class="text-danger font-weight-bold mb-1">{{ trans('admin.teachers.warning_title') ?? trans('admin.global.warning') }}</h6>
            <p class="text-muted mb-0 tx-13">{{ trans('admin.teachers.warning_body') ?? trans('admin.global.archive_warning') }}</p>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card teacher-glass-card-archive">
                <div class="archive-table-card-header pb-0">
                    <div class="archive-table-title">
                        <span class="title-dot"></span>
                        {{ __('admin.teachers.archived') }}
                        <span class="archive-count-badge" id="archive_count">{{ $teachers->count() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="teachers_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.teacher_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.national_id') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.teachers.fields.status') }}</th>
                                @canany(['restore_teachers','force-delete_teachers'])
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="#" class="text-primary font-weight-bold show-btn"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-employee_code="{{ $teacher->employee_code }}"
                                           data-name_ar="{{ $teacher->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $teacher->getTranslation('name', 'en') }}"
                                           data-email="{{ $teacher->email }}"
                                           data-national_id="{{ $teacher->national_id }}"
                                           data-gender="{{ optional($teacher->gender)->name }}"
                                           data-blood_type="{{ optional($teacher->bloodType)->name }}"
                                           data-nationality="{{ optional($teacher->nationality)->name }}"
                                           data-religion="{{ optional($teacher->religion)->name }}"
                                           data-specialization="{{ optional($teacher->specialization)->name }}"
                                           data-joining_date="{{ $teacher->joining_date->format('Y-m-d') }}"
                                           data-address="{{ $teacher->address }}"
                                           data-phone="{{ $teacher->phone }}"
                                           data-status="{{ $teacher->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
                                           data-image="{{ $teacher->imageUrl }}"
                                           data-attachments='@json($teacher->attachments->map(function($att) {
                                               return [
                                                   "url" => asset("storage/" . $att->attachment_path),
                                                   "name" => basename($att->attachment_path)
                                               ];
                                           }))'>
                                            {{ $teacher->employee_code }}
                                        </a>
                                    </td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->email }}</td>
                                    <td>{{ $teacher->national_id }}</td>
                                    <td>{{ $teacher->phone }}</td>
                                    <td>
                                        @if ($teacher->status)
                                            <span class="label text-success d-flex">{{ trans('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ trans('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    @canany(['restore_teachers','force-delete_teachers'])
                                        <td>
                                            <div class="teacher-actions-container">
                                                @can('restore_teachers')
                                                    <a class="btn btn-sm btn-teacher-restore restore-item"
                                                       href="#"
                                                       data-url="{{ route('admin.teachers.restore', $teacher->id) }}"
                                                       data-id="{{ $teacher->id }}"
                                                       data-name="{{ $teacher->name }}"
                                                    >
                                                        <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                    </a>
                                                @endcan
                                                @can('force-delete_teachers')
                                                    <a class="btn btn-sm btn-teacher-delete delete-item"
                                                       href="#"
                                                       data-id="{{ $teacher->id }}"
                                                       data-url="{{ route('admin.teachers.forceDelete', $teacher->id) }}"
                                                       data-name="{{ $teacher->name }}">
                                                        <i class="las la-trash"></i> {{trans('admin.global.delete')}}
                                                    </a>
                                                @endcan
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
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')
    @include('admin.teachers.show_modal')

    <script>
        $(document).ready(function() {
            $('#teachers_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
