@extends('admin.layouts.master')
@section('title')
    {{ __('admin.Academic.subjects.archived') }}
@endsection
@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/LMS/subject/archived.css') }}" rel="stylesheet">
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
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.Academic.subjects.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.Academic.subjects.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.Academic.subjects.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
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
            <h6 class="text-danger font-weight-bold mb-1">{{ __('admin.Academic.subjects.warning_title') }}</h6>
            <p class="text-muted mb-0 tx-13">{!! __('admin.Academic.subjects.warning_body') !!}</p>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-archive table-hover text-md-nowrap" id="archive_table">
                            <thead>
                            <tr>
                                <th class="wd-5p">#</th>
                                <th class="wd-25p">{{ __('admin.Academic.subjects.fields.name') }}</th>
                                <th class="wd-15p">{{ __('admin.Academic.subjects.fields.specialization_id') }}</th>
                                <th class="wd-15p">{{ __('admin.Academic.subjects.fields.grade_id') }}</th>
                                <th class="wd-15p">{{ __('admin.Academic.subjects.fields.classroom_id') }}</th>
                                <th class="wd-15p text-center"><i class="las la-clock"></i> {{ __('admin.Academic.subjects.deleted_at') }}</th>
                                @canany(['restore_subjects', 'force-delete_subjects'])
                                    <th class="wd-15p text-center">{{ __('admin.global.actions') }}</th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subjects as $subject)
                                <tr>
                                    <td class="font-weight-bold text-muted align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 ml-3">
                                                <span class="avatar-initial bg-light text-muted shadow-sm tx-14 border" style="border-radius: 8px;">
                                                    <i class="las la-book-dead"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 font-weight-bold text-secondary" style="text-decoration: line-through; opacity: 0.7;">
                                                    {{ $subject->getTranslation('name', 'ar') }}
                                                </h6>
                                                <small class="text-muted">{{ $subject->getTranslation('name', 'en') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <span class="badge badge-light border text-muted">{{ $subject->specialization->name ?? '-' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold tx-13 text-muted">{{ $subject->grade->name ?? '-' }}</div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="text-muted tx-13">{{ $subject->classroom->name ?? '-' }}</div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-danger-transparent p-2">
                                            {{ $subject->deleted_at->format('Y-m-d') }}
                                            <small class="d-block mt-1">{{ $subject->deleted_at->diffForHumans() }}</small>
                                        </span>
                                    </td>
                                    
                                    @canany(['restore_subjects', 'force-delete_subjects'])
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center align-items-center">
                                            @can('view-archived_subjects')
                                            <a class="btn btn-sm btn-light shadow-sm mx-1 show-subject-btn text-info px-2 py-1"
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
                                               title="{{ __('admin.global.view') }}"
                                               style="border-radius: 6px;">
                                                <i class="las la-eye tx-18"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('restore_subjects')
                                            <a class="btn btn-sm btn-restore shadow-sm mx-1 restore-subject-btn text-success btn-light restore-item px-2 py-1"
                                               href="#"
                                               data-url="{{ route('admin.Academic.subjects.restore', $subject->id) }}"
                                               title="{{ __('admin.Academic.subjects.restore') }}"
                                               data-id="{{ $subject->id }}"
                                               data-name="{{ $subject->name }}"
                                               style="border-radius: 6px;">
                                                <i class="las la-trash-restore tx-18"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('force-delete_subjects')
                                            <a class="btn btn-sm btn-force-delete shadow-sm mx-1 force-delete-btn text-danger btn-light delete-item px-2 py-1"
                                               href="#"
                                               data-url="{{ route('admin.Academic.subjects.forceDelete', $subject->id) }}"
                                               data-id="{{ $subject->id }}"
                                               data-name="{{ $subject->name }}"
                                               title="{{ __('admin.Academic.subjects.force_delete') }}"
                                               style="border-radius: 6px;">
                                                <i class="las la-skull-crossbones tx-18"></i>
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
    @include('admin.Academic.subjects.show_modal')
@endsection

@section('js')
    <!-- <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script> -->

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')
 
    <script>
        $(document).ready(function() {
            var table = $('#archive_table').DataTable({
                ...globalTableConfig,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[5, "desc"]]
            });
        });
    </script>
    @stack('scripts')
@endsection
