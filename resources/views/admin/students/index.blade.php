@extends('admin.layouts.master')

@section('title', trans('admin.students.title'))

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
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.students.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_students')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-warning-gradient btn-with-icon btn-block"
                       href="{{route('admin.students.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{trans('admin.students.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_students')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary-gradient btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ trans('admin.students.add') }}
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
                        <table class="table text-md-nowrap" id="students_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.student_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.name') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.guardian') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.grade') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.classroom') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.section') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.students.fields.status') }}</th>
                                @canany('edit_students','delete_students')
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->student_code }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->guardian->name_father }}</td>
                                    <td>{{ $student->grade->name }}</td>
                                    <td>{{ $student->classroom->name }}</td>
                                    <td>{{ $student->section->name }}</td>
                                    <td>
                                        @if ($student->status)
                                            <span class="label text-success d-flex">{{ trans('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ trans('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    @canany('edit_students','delete_students')
                                            <td>
                                                @can('edit_students')
                                                    @php
                                                        $attachmentUrls = [];
                                                        $attachmentConfigs = [];

                                                        if(!empty($student->attachments) && is_array($student->attachments)) {
                                                            foreach($student->attachments as $index => $filePath) {
                                                                $fullUrl = asset('storage/' . $filePath);
                                                                $attachmentUrls[] = $fullUrl;

                                                                $fileName = basename($filePath);
                                                                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                                                                $type = 'other';
                                                                if(in_array($extension, ['jpg', 'jpeg', 'png', 'svg'])) {
                                                                    $type = 'image';
                                                                } elseif ($extension == 'pdf') {
                                                                    $type = 'pdf';
                                                                } elseif (in_array($extension, ['doc', 'docx'])) {
                                                                    $type = 'office';
                                                                }

                                                                $attachmentConfigs[] = [
                                                                    'caption' => $fileName,
                                                                    'type' => $type,
                                                                    'key' => $index + 1
                                                                ];
                                                            }
                                                        }
                                                    @endphp
                                                    <a class="btn btn-info btn-sm edit-btn"
                                                       href="#"
                                                       data-toggle="modal"
                                                       data-target="#editModal"
                                                       data-url="{{ route('admin.students.update', $student->id) }}"
                                                       data-student_code="{{ $student->student_code }}"
                                                       data-name_ar="{{ $student->getTranslation('name', 'ar') }}"
                                                       data-name_en="{{ $student->getTranslation('name', 'en') }}"
                                                       data-email="{{ $student->email }}"
                                                       data-national_id="{{ $student->national_id }}"
                                                       data-date_of_birth="{{ $student->date_of_birth->format('d-m-Y') }}"
                                                       data-grade_id="{{ $student->grade_id }}"
                                                       data-classroom_id="{{ $student->classroom_id }}"
                                                       data-section_id="{{ $student->section_id }}"
                                                       data-academic_year="{{ $student->academic_year }}"
                                                       data-status="{{ $student->status }}"
                                                       data-guardian_id="{{ $student->guardian_id }}"
                                                       data-blood_type_id="{{ $student->blood_type_id }}"
                                                       data-nationality_id="{{ $student->nationality_id }}"
                                                       data-religion_id="{{ $student->religion_id }}"
                                                       data-gender_id="{{ $student->gender_id }}"
                                                       data-admin_id="{{ $student->admin_id }}"
                                                       data-image="{{ $student->image_path ? asset('storage/' . $student->image_path) : '' }}"
                                                       data-attachments='@json($attachmentUrls)'
                                                       data-configs='@json($attachmentConfigs)'>
                                                        <i class="las la-pen"></i> {{trans('admin.global.edit')}}
                                                    </a>
                                                @endcan
                                                @can('delete_students')
                                                    <a class="modal-effect btn btn-sm btn-danger delete-item"
                                                       href="#"
                                                       data-id="{{ $student->id }}"
                                                       data-url="{{ route('admin.students.destroy', $student->id) }}"
                                                       data-name="{{ $student->name }}">
                                                        <i class="las la-trash"></i> {{trans('admin.global.archive')}}
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

    @include('admin.students.add_modal')
    @include('admin.students.edit_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/file-upload.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            $('#students_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{trans("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
