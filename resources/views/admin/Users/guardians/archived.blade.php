@extends('admin.layouts.master')

@section('title', __('admin.Academic.sections.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    {{-- Guardian Dedicated CSS --}}
    <link href="{{ URL::asset('assets/admin/css/Users/guardian/archive.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/css/Users/guardian/show.css') }}" rel="stylesheet" />

    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="guardian-archive-header d-flex justify-content-between align-items-center mt-4">
        <div class="d-flex align-items-center">
            <div class="mr-3 ml-3">
                <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="las la-trash-alt tx-24 text-white"></i>
                </div>
            </div>
            <div>
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.Academic.sections.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.Users.teachers.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.Users.guardians.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
                <i class="las la-arrow-right mr-1 ml-1"></i> {{ __('admin.global.back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            
            <div class="guardian-archive-alert shadow-sm">
                <i class="las la-exclamation-triangle tx-24 text-danger mr-2 ml-2"></i>
                <div>
                    <strong class="text-danger">{{ __('admin.Users.teachers.warning_title') }}</strong>
                    <p class="mb-0 tx-13 text-muted">{{ __('admin.Users.teachers.warning_body') }}</p>
                </div>
            </div>

            <div class="guardian-glass-card-archive">
                <div class="archive-table-card-header">
                    <div class="archive-table-title">
                        <div class="title-dot"></div>
                        {{ __('admin.Academic.sections.archived') }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap" id="guardians_table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('admin.Users.guardians.fields.email') }}</th>
                                <th>{{ __('admin.Users.guardians.fields.name_father') }}</th>
                                <th>{{ __('admin.Users.guardians.fields.national_id_father') }}</th>
                                <th>{{ __('admin.Users.guardians.fields.phone_father') }}</th>
                                <th>{{ __('admin.Users.guardians.fields.name_mother') }}</th>
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
                                    <td>
                                        @php
                                            $gAttUrls = [];
                                            if (!empty($guardian->attachments) && is_array($guardian->attachments)) {
                                                foreach ($guardian->attachments as $att) {
                                                    $gAttUrls[] = asset('storage/' . $att);
                                                }
                                            }
                                        @endphp
                                        <a href="#" class="text-primary font-weight-bold guardian-show-btn"
                                           data-toggle="modal"
                                           data-target="#guardianShowModal"
                                           data-email="{{ $guardian->email }}"
                                           data-raw_status="{{ $guardian->status ?? 1 }}"
                                           data-image="{{ $guardian->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($guardian->image) : '' }}"
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
                                           data-attachments='@json($gAttUrls)'>
                                            {{ $guardian->name_father }}
                                        </a>
                                    </td>
                                    <td>{{ $guardian->national_id_father }}</td>
                                    <td>{{ $guardian->phone_father }}</td>
                                    <td>{{ $guardian->name_mother }}</td>
                                    @canany(['restore_guardians','force-delete_guardians'])
                                        <td>
                                            <div class="guardian-actions-container">
                                                @can('restore_guardian')
                                                    <a class="btn-guardian-restore restore-item"
                                                       href="#"
                                                       data-url="{{ route('admin.Users.guardians.restore', $guardian->id) }}"
                                                       data-id="{{ $guardian->id }}"
                                                       data-name="{{ $guardian->name }}"
                                                    >
                                                        <i class="las la-store"></i> {{__('admin.global.restore')}}
                                                    </a>
                                                @endcan
                                                @can('force-delete_guardian')
                                                    <a class="modal-effect btn-guardian-delete delete-item"
                                                       href="#"
                                                       data-id="{{ $guardian->id }}"
                                                       data-url="{{ route('admin.Users.guardians.forceDelete', $guardian->id) }}"
                                                       data-name="{{ $guardian->name }}">
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

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')
    @include('admin.Users.guardians.show_modal')

    <script>
        $(document).ready(function() {
            $('#guardians_table').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });
        });
    </script>
    @stack('scripts')
@endsection
