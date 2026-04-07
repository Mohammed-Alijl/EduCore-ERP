@extends('admin.layouts.master')

@section('title', trans('admin.Users.teachers.title'))

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
    {{-- Teacher CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/teacher-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Users/teacher/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.Users.teachers.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_teachers')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-danger btn-with-icon btn-block"
                       href="{{route('admin.Users.teachers.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{trans('admin.Users.teachers.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_teachers')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ trans('admin.Users.teachers.add') }}
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card teacher-glass-card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="teachers_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-5p border-bottom-0">{{ trans('admin.Users.teachers.fields.image') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.Users.teachers.fields.teacher_code') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.Users.teachers.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.Users.teachers.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.Users.teachers.fields.national_id') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.Users.teachers.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.Users.teachers.fields.status') }}</th>
                                @canany(['edit_teachers','delete_teachers'])
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $teacher)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img alt="avatar" class="avatar avatar-md brround bg-white" src="{{ $teacher->image_url}}">
                                    </td>
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
                                    @canany(['edit_teachers','delete_teachers'])
                                            <td>
                                                <div class="teacher-actions-container">
                                                    @can('edit_teachers')
                                                        @php
                                                            $attachmentUrls = [];
                                                            $attachmentConfigs = [];

                                                            if($teacher->attachments->count() > 0) {
                                                                foreach($teacher->attachments as $attachment) {
                                                                    $filePath = $attachment->attachment_path;
                                                                    $fullUrl = asset('storage/' . $filePath);
                                                                    $attachmentUrls[] = $fullUrl;

                                                                    $fileName = basename($filePath);
                                                                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);


                                                                    if(in_array($extension, ['jpg', 'jpeg', 'png', 'svg']))
                                                                        $type = 'image';
                                                                     elseif ($extension == 'pdf')
                                                                        $type = 'pdf';
                                                                     elseif (in_array($extension, ['doc', 'docx']))
                                                                        $type = 'office';
                                                                     else
                                                                        $type = 'other';

                                                                    $attachmentConfigs[] = [
                                                                        'caption' => $fileName,
                                                                        'type' => $type,
                                                                        'url' => route('admin.Users.teachers.attachments.destroy', $attachment->id),
                                                                        'key' => $attachment->id
                                                                    ];
                                                                }
                                                            }
                                                        @endphp
                                                        <a class="btn btn-teacher-edit btn-sm edit-btn"
                                                           href="#"
                                                           data-toggle="modal"
                                                           data-target="#editModal"
                                                           data-url="{{ route('admin.Users.teachers.update', $teacher->id) }}"
                                                           data-name_ar="{{ $teacher->getTranslation('name', 'ar') }}"
                                                           data-name_en="{{ $teacher->getTranslation('name', 'en') }}"
                                                           data-email="{{ $teacher->email }}"
                                                           data-national_id="{{ $teacher->national_id }}"
                                                           data-gender_id="{{ $teacher->gender_id }}"
                                                           data-blood_type_id="{{ $teacher->blood_type_id }}"
                                                           data-nationality_id="{{ $teacher->nationality_id }}"
                                                           data-religion_id="{{ $teacher->religion_id }}"
                                                           data-specialization_id="{{ $teacher->specialization_id }}"
                                                           data-joining_date="{{ $teacher->joining_date->format('Y-m-d') }}"
                                                           data-address="{{ $teacher->address }}"
                                                           data-phone="{{ $teacher->phone }}"
                                                           data-status="{{ $teacher->status }}"
                                                           data-image="{{ $teacher->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($teacher->image) : '' }}"
                                                           data-attachments='@json($attachmentUrls)'
                                                           data-configs='@json($attachmentConfigs)'>
                                                            <i class="las la-pen"></i> {{trans('admin.global.edit')}}
                                                        </a>
                                                    @endcan
                                                    @can('delete_teachers')
                                                        <a class="modal-effect btn btn-sm btn-teacher-archive delete-item"
                                                           href="#"
                                                           data-id="{{ $teacher->id }}"
                                                           data-url="{{ route('admin.Users.teachers.destroy', $teacher->id) }}"
                                                           data-name="{{ $teacher->name }}">
                                                            <i class="las la-trash"></i> {{trans('admin.global.archive')}}
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

    @include('admin.Users.teachers.add_modal')
    @include('admin.Users.teachers.edit_modal')
    @include('admin.Users.teachers.show_modal')

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
            $('#teachers_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{trans("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
