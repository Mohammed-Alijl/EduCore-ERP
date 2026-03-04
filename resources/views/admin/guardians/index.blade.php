@extends('admin.layouts.master')

@section('title', __('admin.guardians.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- Guardian Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/guardian/guardian-crud.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/css/guardian/show.css') }}" rel="stylesheet" />
    
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    {{--  File uploader css --}}
    <link href="{{URL::asset('assets/admin/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
    {{-- Internal  TelephoneInput css --}}
    <link rel="stylesheet" href="{{URL::asset('assets/admin/plugins/telephoneinput/telephoneinput-rtl.css')}}">
{{-- Internal  TelephoneInput css --}}
    <link rel="stylesheet" href="{{URL::asset('assets/admin/plugins/telephoneinput/telephoneinput-rtl.css')}}">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ __('admin.sidebar.users') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('admin.guardians.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_guardians')
                <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-danger btn-with-icon btn-block"
                       href="{{route('admin.guardians.archived')}}">
                        <i class="fas fa-book ml-2"></i>  {{__('admin.guardians.archived') }}
                    </a>
                </div>
            @endcan
            @can('create_guardians')
                <div class="pr-1 mb-3 mb-xl-0">
                    <a class="modal-effect btn btn-primary btn-with-icon btn-block"
                       data-effect="effect-scale"
                       data-toggle="modal"
                       href="#addModal">
                        <i class="fas fa-user-plus ml-2"></i> {{ __('admin.guardians.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card guardian-glass-card">
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
                                @canany(['edit_guardians','delete_guardians'])
                                <th>{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($guardians as $guardian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $guardian->email }}</td>
                                    <td>
                                        @php
                                            $gAttUrls = [];
                                            if (!empty($guardian->attachments) && is_array($guardian->attachments)) {
                                                foreach ($guardian->attachments as $att) {
                                                    $gAttUrls[] = asset('storage/' . $att);
                                                }
                                            }
                                            $gChildren = [];
                                            foreach($guardian->students as $child) {
                                                $gChildren[] = [
                                                    'id' => $child->id,
                                                    'name' => $child->name,
                                                    'code' => $child->student_code,
                                                    'email' => $child->email,
                                                    'image' => $child->imageUrl,
                                                    'grade' => optional($child->grade)->name,
                                                    'classroom' => optional($child->classroom)->name,
                                                    'section' => optional($child->section)->name,
                                                    'gender' => optional($child->gender)->name,
                                                    'nationality' => optional($child->nationality)->name,
                                                    'blood_type' => optional($child->bloodType)->name,
                                                    'religion' => optional($child->religion)->name,
                                                    'date_of_birth' => $child->date_of_birth ? $child->date_of_birth->format('Y-m-d') : null,
                                                    'academic_year' => $child->academic_year,
                                                    'status' => $child->status,
                                                ];
                                            }
                                        @endphp
                                        <a href="#" class="text-primary font-weight-bold guardian-show-btn"
                                           data-toggle="modal"
                                           data-target="#guardianShowModal"
                                           data-email="{{ $guardian->email }}"
                                           data-raw_status="{{ $guardian->status ?? 1 }}"
                                           data-image="{{ $guardian->imageUrl }}"
                                           data-name_father_ar="{{ $guardian->getTranslation('name_father', 'ar') }}"
                                           data-name_father_en="{{ $guardian->getTranslation('name_father', 'en') }}"
                                           data-national_id_father="{{ $guardian->national_id_father }}"
                                           data-passport_id_father="{{ $guardian->passport_id_father }}"
                                           data-phone_father="{{ $guardian->phone_father }}"
                                           data-job_father_ar="{{ $guardian->job_father ? $guardian->getTranslation('job_father', 'ar') : '' }}"
                                           data-job_father_en="{{ $guardian->job_father ? $guardian->getTranslation('job_father', 'en') : '' }}"
                                           data-address_father="{{ $guardian->address_father }}"
                                           data-nationality_father="{{ optional($guardian->nationalityFather)->name }}"
                                           data-blood_type_father="{{ optional($guardian->bloodTypeFather)->name }}"
                                           data-religion_father="{{ optional($guardian->religionFather)->name }}"
                                           data-name_mother_ar="{{ $guardian->name_mother ? $guardian->getTranslation('name_mother', 'ar') : '' }}"
                                           data-name_mother_en="{{ $guardian->name_mother ? $guardian->getTranslation('name_mother', 'en') : '' }}"
                                           data-national_id_mother="{{ $guardian->national_id_mother }}"
                                           data-passport_id_mother="{{ $guardian->passport_id_mother }}"
                                           data-phone_mother="{{ $guardian->phone_mother }}"
                                           data-job_mother_ar="{{ $guardian->job_mother ? $guardian->getTranslation('job_mother', 'ar') : '' }}"
                                           data-job_mother_en="{{ $guardian->job_mother ? $guardian->getTranslation('job_mother', 'en') : '' }}"
                                           data-address_mother="{{ $guardian->address_mother }}"
                                           data-nationality_mother="{{ optional($guardian->nationalityMother)->name }}"
                                           data-blood_type_mother="{{ optional($guardian->bloodTypeMohter)->name }}"
                                           data-religion_mother="{{ optional($guardian->religionMother)->name }}"
                                           data-attachments='@json($gAttUrls)'
                                           data-children='@json($gChildren)'>
                                            {{ $guardian->name_father }}
                                        </a>
                                    </td>
                                    <td>{{ $guardian->national_id_father }}</td>
                                    <td>{{ $guardian->phone_father }}</td>
                                    <td>{{ $guardian->name_mother }}</td>
                                    @canany(['edit_guardians','delete_guardians'])
                                    <td>
                                        <div class="guardian-actions-container">
                                            @can('edit_guardians')
                                                <a class="btn-guardian-edit edit-btn"
                                                   href="#"
                                                   data-toggle="modal"
                                                   data-target="#editModal"
                                                   data-url="{{ route('admin.guardians.update', $guardian->id) }}"
                                                   data-id="{{ $guardian->id }}"
                                                   data-email="{{ $guardian->email }}"
                                                   data-name_father_ar="{{ $guardian->getTranslation('name_father', 'ar') }}"
                                                   data-name_father_en="{{ $guardian->getTranslation('name_father', 'en') }}"
                                                   data-national_id_father="{{ $guardian->national_id_father }}"
                                                   data-passport_id_father="{{ $guardian->passport_id_father }}"
                                                   data-phone_father="{{ $guardian->phone_father }}"
                                                   data-job_father_ar="{{ $guardian->getTranslation('job_father', 'ar') }}"
                                                   data-job_father_en="{{ $guardian->getTranslation('job_father', 'en') }}"
                                                   data-nationality_father_id="{{ $guardian->nationality_father_id }}"
                                                   data-blood_type_father_id="{{ $guardian->blood_type_father_id }}"
                                                   data-religion_father_id="{{ $guardian->religion_father_id }}"
                                                   data-address_father="{{ $guardian->address_father }}"
                                                   data-name_mother_ar="{{ $guardian->name_mother ? $guardian->getTranslation('name_mother', 'ar') : '' }}"
                                                   data-name_mother_en="{{ $guardian->name_mother ? $guardian->getTranslation('name_mother', 'en') : '' }}"
                                                   data-national_id_mother="{{ $guardian->national_id_mother }}"
                                                   data-passport_id_mother="{{ $guardian->passport_id_mother }}"
                                                   data-phone_mother="{{ $guardian->phone_mother }}"
                                                   data-job_mother_ar="{{ $guardian->job_mother ? $guardian->getTranslation('job_mother', 'ar') : '' }}"
                                                   data-job_mother_en="{{ $guardian->job_mother ? $guardian->getTranslation('job_mother', 'en') : '' }}"
                                                   data-nationality_mother_id="{{ $guardian->nationality_mother_id }}"
                                                   data-blood_type_mother_id="{{ $guardian->blood_type_mother_id }}"
                                                   data-religion_mother_id="{{ $guardian->religion_mother_id }}"
                                                   data-address_mother="{{ $guardian->address_mother }}"
                                                   data-image="{{ $guardian->image_url }}"
                                                >
                                                    <i class="las la-pen"></i> {{__('admin.global.edit')}}
                                                </a>
                                            @endcan
    
                                            @can('delete_guardians')
                                                <a class="modal-effect btn-guardian-archive delete-item"
                                                   href="#"
                                                   data-id="{{ $guardian->id }}"
                                                   data-url="{{ route('admin.guardians.destroy', $guardian->id) }}">
                                                    <i class="las la-trash"></i> {{__('admin.global.delete')}}
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

    @include('admin.guardians.add_modal')
    @include('admin.guardians.edit_modal')
    @include('admin.guardians.show_modal')

@endsection

@section('js')
    {{--  Datatables JS  --}}
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    {{-- Select 2 JS --}}
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    {{--  Parsley Validation Form JS  --}}
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    {{-- Form-wizard JS --}}
    <script src="{{URL::asset('assets/admin/plugins/jquery-steps/jquery.steps.min.js')}}"></script>
    {{--  Main CRUD JS For Edit & Update  --}}
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>
    {{--  Dropify JS  --}}
    <script src="{{URL::asset('assets/admin/plugins/fileuploads/js/fileupload.js')}}"></script>
    <!--Telephone Input js-->
    <script src="{{URL::asset('assets/admin/plugins/telephoneinput/telephoneinput.js')}}"></script>
    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            $('#guardians_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%',
                dropdownParent: $('.modal')
            });
        });
    </script>
    @stack('scripts')
@endsection
