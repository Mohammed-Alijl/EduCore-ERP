@extends('admin.layouts.master')

@section('title', __('admin.subjects.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">

    <style>
        .glass-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            border: 1px solid rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08) !important;
        }
        .filter-section {
            background: #f8f9fc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px dashed #e3e6f0;
        }
        .btn-modern {
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            letter-spacing: 0.3px;
        }
        .badge-modern {
            padding: 0.5em 1em;
            border-radius: 30px;
            font-weight: 600;
            font-size: 85%;
            letter-spacing: 0.5px;
        }
        .badge-active {
            background-color: #e3fcef;
            color: #0d965e;
            border: 1px solid #c9f5e1;
        }
        .badge-inactive {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        .table-hover tbody tr:hover {
            background-color: #f8fafc;
            transform: scale(1.002);
            transition: transform 0.2s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        }
        table.dataTable thead th, table.dataTable thead td {
            border-bottom: 2px solid #edf2f7 !important;
            color: #4a5568;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .avatar-initial {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: #fff;
        }
        .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
        .bg-gradient-info { background: linear-gradient(135deg, #36b9cc 0%, #17a673 100%); }
        .bg-gradient-success { background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); }
        .bg-gradient-warning { background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); }

        .form-control-modern {
            border-radius: 8px;
            border: 1px solid #e3e6f0;
            padding: 0.6rem 1rem;
            box-shadow: none;
            transition: border-color 0.2s;
        }
        .form-control-modern:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        .action-icon-btn {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .action-icon-btn:hover {
            transform: translateY(-2px);
        }
    </style>
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
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ __('admin.subjects.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ __('admin.subjects.list') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            @can('view-archived_subjects')
            <div class="pr-1 mb-3 mb-xl-0 mr-2">
                <a class="btn btn-danger btn-modern shadow-sm"
                   href="{{ route('admin.subjects.archived') }}">
                    <i class="las la-trash-alt tx-18 mr-2 ml-1"></i> {{ __('admin.subjects.archive') }}
                </a>
            </div>
            @endcan

            @can('create_subjects')
            <div class="pr-1 mb-3 mb-xl-0">
                <a class="modal-effect btn btn-primary btn-modern shadow-sm"
                   data-effect="effect-scale"
                   data-toggle="modal"
                   href="#addModal">
                    <i class="las la-plus-circle tx-18 mr-2"></i> {{ __('admin.subjects.add') }}
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
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-filter"></i> {{ __('admin.subjects.filter_grade') }}</label>
                        <select class="form-control form-control-modern" id="filter_grade">
                            <option value="">{{ __('admin.subjects.all_grades') }}</option>
                            @foreach($lookups['grades'] as $grade)
                                <option value="{{ $grade->id }}" data-name="{{ $grade->name }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-chalkboard"></i> {{ __('admin.subjects.filter_classroom') }}</label>
                        <select class="form-control form-control-modern" id="filter_classroom" disabled>
                            <option value="">{{ __('admin.subjects.all_classrooms') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label tx-12 font-weight-bold text-uppercase text-muted"><i class="las la-sliders-h"></i> {{ __('admin.subjects.filter_specialization') }}</label>
                        <select class="form-control form-control-modern" id="filter_specialization">
                            <option value="">{{ __('admin.subjects.all_specializations') }}</option>
                            @foreach($lookups['specializations'] as $spec)
                                <option value="{{ $spec->name }}">{{ $spec->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-right">
                        <button class="btn btn-light btn-modern text-muted" id="reset_filters">
                            <i class="las la-sync"></i> {{ __('admin.subjects.reset_filters') }}
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
                                <th class="wd-25p border-bottom-0">{{ __('admin.subjects.fields.name') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.subjects.fields.specialization_id') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.subjects.fields.grade_id') }}</th>
                                <th class="wd-15p border-bottom-0">{{ __('admin.subjects.fields.classroom_id') }}</th>
                                <th class="wd-10p border-bottom-0 text-center">{{ __('admin.subjects.fields.status') }}</th>
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
                                            <span class="badge badge-modern badge-active"><i class="las la-check-circle mr-1 ml-1"></i> {{ __('admin.subjects.active') }}</span>
                                        @else
                                            <span class="badge badge-modern badge-inactive"><i class="las la-times-circle mr-1 ml-1"></i> {{ __('admin.subjects.inactive') }}</span>
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
                                           data-url="{{ route('admin.subjects.update', $subject->id) }}"
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
                                               data-url="{{ route('admin.subjects.destroy', $subject->id) }}"
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
    @include('admin.subjects.add_modal')
     @include('admin.subjects.edit_modal')
    @include('admin.subjects.show_modal')

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
                classroomSelect.empty().append('<option value="">{{ __('admin.subjects.all_classrooms') }}</option>');

                table.column(4).search('').draw();

                if (gradeId) {
                    $.ajax({
                        url: "{{ route('admin.classrooms.by-grade') }}",
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
