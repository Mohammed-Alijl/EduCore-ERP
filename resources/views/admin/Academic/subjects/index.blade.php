@extends('admin.layouts.master')

@section('title', __('admin.Academic.subjects.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('assets/admin/css/LMS/subject/subject-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-book-open"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ __('admin.Academic.subjects.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ __('admin.Academic.subjects.list') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_subjects')
            <div class="pr-1 mb-3 mb-xl-0 mr-2">
                <a class="btn btn-danger btn-modern shadow-sm"
                   href="{{ route('admin.Academic.subjects.archived') }}">
                    <i class="las la-trash-alt tx-18 mr-2 ml-1"></i> {{ __('admin.Academic.subjects.archive') }}
                </a>
            </div>
            @endcan

            @can('create_subjects')
            <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="las la-plus-circle tx-18 mr-2"></i> {{ __('admin.Academic.subjects.add') }}
                </a>
            </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">

            <!-- Modern Filter Section -->
            <div class="filter-section shadow-sm">
                <div class="row align-items-end">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-filter"></i> {{ __('admin.Academic.subjects.filter_grade') }}</label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ __('admin.Academic.subjects.all_grades') }}</option>
                            @foreach($lookups['grades'] as $grade)
                                <option value="{{ $grade->id }}" data-name="{{ $grade->name }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-chalkboard"></i> {{ __('admin.Academic.subjects.filter_classroom') }}</label>
                        <select class="form-control form-control-modern" id="filter_classroom" disabled>
                            <option value="">{{ __('admin.Academic.subjects.all_classrooms') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-sliders-h"></i> {{ __('admin.Academic.subjects.filter_specialization') }}</label>
                        <select class="form-control form-control-modern" id="filter_specialization">
                            <option value="">{{ __('admin.Academic.subjects.all_specializations') }}</option>
                            @foreach($lookups['specializations'] as $spec)
                                <option value="{{ $spec->name }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-light btn-modern text-muted" id="reset_filters">
                            <i class="las la-sync"></i> {{ __('admin.Academic.subjects.reset_filters') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover text-md-nowrap" id="subjects_table">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-25p border-bottom-0">{{ __('admin.Academic.subjects.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.Academic.subjects.fields.specialization_id') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.Academic.subjects.fields.grade_id') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.Academic.subjects.fields.classroom_id') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.Academic.subjects.fields.status') }}</th>
                                @canany(['edit_subjects','delete_subjects','view_subjects'])
                                    <th class="wd-15p border-bottom-0 text-center">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td class="font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 ml-3">
                                                @php
                                                    $colors = ['bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-success', 'bg-gradient-warning'];
                                                    $color = $colors[$loop->index % 4];
                                                @endphp
                                                <span class="avatar-initial {{ $color }} shadow-sm tx-14">
                                                    {{ mb_substr($subject->getTranslation('name', 'ar'), 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 font-weight-bold">{{ $subject->getTranslation('name', 'ar') }}</h6>
                                                <small class="text-muted">{{ $subject->getTranslation('name', 'en') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ $subject->specialization->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold tx-13">{{ $subject->grade->name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted tx-13"><i class="las la-chalkboard text-info"></i> {{ $subject->classroom->name ?? '-' }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($subject->status == 1)
                                            <span class="badge badge-modern badge-active"><i class="las la-check-circle mr-1 ml-1"></i> {{ __('admin.Academic.subjects.active') }}</span>
                                        @else
                                            <span class="badge badge-modern badge-inactive"><i class="las la-times-circle mr-1 ml-1"></i> {{ __('admin.Academic.subjects.inactive') }}</span>
                                        @endif
                                    </td>
                                    @canany(['edit_subjects','delete_subjects','view_subjects'])
                                    <td class="text-center">
                                        @can('view_subjects')
                                        <a class="btn btn-light action-icon-btn btn-sm show-subject-btn shadow-sm text-info"
                                           href="javascript:void(0)"
                                           data-id="{{ $subject->id }}"
                                           data-name_ar="{{ $subject->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $subject->getTranslation('name', 'en') }}"
                                           data-status="{{ $subject->status }}"
                                           data-grade="{{ $subject->grade->name ?? '-' }}"
                                           data-classroom="{{ $subject->classroom->name ?? '-' }}"
                                           data-specialization="{{ $subject->specialization->name ?? '-' }}"
                                           data-updated-at="{{ $subject->updated_at ? $subject->updated_at->diffForHumans() : '' }}"
                                           data-students="{{ $subject->classroom ? $subject->classroom->students()->count() : 0 }}"
                                           data-sections="{{ $subject->classroom ? $subject->classroom->sections()->count() : 0 }}"
                                           data-teachers="0"
                                        >
                                            <i class="las la-eye tx-16"></i>
                                        </a>
                                        @endcan
                                        @can('edit_subjects')
                                        <a class="btn btn-light action-icon-btn btn-sm edit-btn shadow-sm text-primary"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#editModal"
                                           data-id="{{ $subject->id }}"
                                           data-url="{{ route('admin.Academic.subjects.update', $subject->id) }}"
                                           data-name_ar="{{ $subject->getTranslation('name', 'ar') }}"
                                           data-name_en="{{ $subject->getTranslation('name', 'en') }}"
                                           data-specialization_id="{{ $subject->specialization_id }}"
                                           data-grade_id="{{ $subject->grade_id }}"
                                           data-classroom_id="{{ $subject->classroom_id }}"
                                           data-status="{{ $subject->status }}"
                                        >
                                            <i class="las la-pen tx-16"></i>
                                        </a>
                                        @endcan
                                        @can('delete_subjects')
                                            <a class="modal-effect btn btn-light action-icon-btn btn-sm delete-item shadow-sm text-danger ml-1"
                                               href="#"
                                               data-id="{{ $subject->id }}"
                                               data-url="{{ route('admin.Academic.subjects.destroy', $subject->id) }}"
                                               data-name="{{ $subject->name }}">
                                                <i class="las la-trash tx-16"></i>
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
    @include('admin.Academic.subjects.add_modal')
     @include('admin.Academic.subjects.edit_modal')
    @include('admin.Academic.subjects.show_modal')

@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js')}}"></script>
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            var table = $('#subjects_table').DataTable({
                ...globalTableConfig,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            $('#filter_grade').on('change', function () {
                let gradeId = $(this).val();
                let gradeName = $(this).find(':selected').data('name') || '';

                table.column(3).search(gradeName).draw();

                let classroomSelect = $('#filter_classroom');
                classroomSelect.empty().append('<option value="">{{ __('admin.Academic.subjects.all_classrooms') }}</option>');

                table.column(4).search('').draw();

                if (gradeId) {
                    $.ajax({
                        url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                        type: "GET",
                        data: { grade_id: gradeId },
                        success: function(response) {
                            let classrooms = response.data;
                            if(classrooms && Object.keys(classrooms).length > 0) {
                                classroomSelect.prop('disabled', false);
                                $.each(classrooms, function(id, name) {
                                    classroomSelect.append('<option value="' + name + '">' + name + '</option>');
                                });
                            } else {
                                classroomSelect.prop('disabled', true);
                            }
                        },
                        error: function() {
                            console.error("Failed to load classrooms.");
                        }
                    });
                } else {
                    classroomSelect.prop('disabled', true);
                }
            });

            $('#filter_classroom').on('change', function () {
                table.column(4).search(this.value).draw();
            });

            $('#filter_specialization').on('change', function () {
                table.column(2).search(this.value).draw();
            });

            $('#reset_filters').on('click', function() {
                $('#filter_grade').val('').trigger('change');
                $('#filter_specialization').val('').trigger('change');
                $('#filter_classroom').val('').prop('disabled', true);
                table.search('').columns().search('').draw();
            });

        });
    </script>
    @stack('scripts')
@endsection
