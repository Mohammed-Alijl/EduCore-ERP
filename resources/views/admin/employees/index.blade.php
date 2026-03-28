@extends('admin.layouts.master')

@section('title', trans('admin.employees.title'))

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
    {{-- Reuse Teacher CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/teacher/teacher-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/teacher/show.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.hr') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.employees.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_employees')
                 <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-danger btn-with-icon btn-block"
                       href="{{route('admin.employees.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{trans('admin.employees.archived') }}
                    </a>
            </div>
            @endcan
            @can('create_employees')
                  <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addEmployeeModal">
                    <i class="fas fa-plus-circle ml-2"></i> {{ trans('admin.employees.add') }}
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
                        <table class="table text-md-nowrap" id="employees_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-5p border-bottom-0">{{ trans('admin.employees.fields.image') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.employee_code') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.designation') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.employees.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ trans('admin.employees.fields.email') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.phone') }}</th>
                                <th class="wd-10p border-bottom-0">{{ trans('admin.employees.fields.status') }}</th>
                                @canany(['edit_employees','delete_employees'])
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img alt="avatar" class="avatar avatar-md brround bg-white" src="{{ $employee->image_url}}">
                                    </td>
                                    <td>
                                        <a href="#" class="text-primary font-weight-bold emp-show-btn"
                                           data-toggle="modal"
                                           data-target="#showEmployeeModal"
                                           data-employee_code="{{ $employee->employee_code }}"
                                           data-designation="{{ optional($employee->designation)->name }}"
                                           data-name_ar="{{ $employee->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $employee->getTranslation('name', 'en') }}"
                                           data-email="{{ $employee->email }}"
                                           data-national_id="{{ $employee->national_id }}"
                                           data-gender="{{ optional($employee->gender)->name }}"
                                           data-blood_type="{{ optional($employee->bloodType)->name }}"
                                           data-nationality="{{ optional($employee->nationality)->name }}"
                                           data-religion="{{ optional($employee->religion)->name }}"
                                           data-specialization="{{ optional($employee->specialization)->name ?? '-' }}"
                                           data-joining_date="{{ $employee->joining_date->format('Y-m-d') }}"
                                           data-address="{{ $employee->address }}"
                                           data-phone="{{ $employee->phone }}"
                                           data-status="{{ $employee->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
                                           data-image="{{ $employee->imageUrl }}"
                                           data-attachments='@json($employee->attachments->map(function($att) {
                                               return [
                                                   "url" => asset("storage/" . $att->attachment_path),
                                                   "name" => basename($att->attachment_path)
                                               ];
                                           }))'>
                                            {{ $employee->employee_code }}
                                        </a>
                                    </td>
                                    <td><span class="badge badge-pill badge-primary-transparent">{{ optional($employee->designation)->name ?? '-' }}</span></td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>
                                        @if ($employee->status)
                                            <span class="label text-success d-flex">{{ trans('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ trans('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    @canany(['edit_employees','delete_employees'])
                                            <td>
                                                <div class="teacher-actions-container">
                                                    @can('edit_employees')
                                                        @php
                                                            $attachmentUrls = [];
                                                            $attachmentConfigs = [];

                                                            if($employee->attachments->count() > 0) {
                                                                foreach($employee->attachments as $attachment) {
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
                                                                        'url' => route('admin.employees.attachments.destroy', $attachment->id),
                                                                        'key' => $attachment->id
                                                                    ];
                                                                }
                                                            }
                                                        @endphp
                                                        <a class="btn btn-teacher-edit btn-sm edit-btn"
                                                           href="#"
                                                           data-toggle="modal"
                                                           data-target="#editEmployeeModal"
                                                           data-url="{{ route('admin.employees.update', $employee->id) }}"
                                                           data-name_ar="{{ $employee->getTranslation('name', 'ar') }}"
                                                           data-name_en="{{ $employee->getTranslation('name', 'en') }}"
                                                           data-email="{{ $employee->email }}"
                                                           data-national_id="{{ $employee->national_id }}"
                                                           data-gender_id="{{ $employee->gender_id }}"
                                                           data-blood_type_id="{{ $employee->blood_type_id }}"
                                                           data-nationality_id="{{ $employee->nationality_id }}"
                                                           data-religion_id="{{ $employee->religion_id }}"
                                                           data-specialization_id="{{ $employee->specialization_id }}"
                                                           data-department_id="{{ $employee->department_id }}"
                                                           data-designation_id="{{ $employee->designation_id }}"
                                                           data-contract_type="{{ $employee->contract_type }}"
                                                           data-basic_salary="{{ $employee->basic_salary }}"
                                                           data-bank_account_number="{{ $employee->bank_account_number }}"
                                                           data-joining_date="{{ $employee->joining_date->format('Y-m-d') }}"
                                                           data-address="{{ $employee->address }}"
                                                           data-phone="{{ $employee->phone }}"
                                                           data-status="{{ $employee->status }}"
                                                           data-image="{{ $employee->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($employee->image) : '' }}"
                                                           data-attachments='@json($attachmentUrls)'
                                                           data-configs='@json($attachmentConfigs)'>
                                                            <i class="las la-pen"></i> {{trans('admin.global.edit')}}
                                                        </a>
                                                    @endcan
                                                    @can('delete_employees')
                                                        <a class="modal-effect btn btn-sm btn-teacher-archive delete-item"
                                                           href="#"
                                                           data-id="{{ $employee->id }}"
                                                           data-url="{{ route('admin.employees.destroy', $employee->id) }}"
                                                           data-name="{{ $employee->name }}">
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

    @include('admin.employees.add_modal')
    @include('admin.employees.edit_modal')
    @include('admin.employees.show_modal')

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
            $('#employees_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{trans("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
