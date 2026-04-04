@extends('admin.layouts.master')

@section('title', __('admin.classrooms.archived'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">

    <link href="{{URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">
    {{-- Classroom Archive Styles --}}
    <link href="{{ URL::asset('assets/admin/css/Academic/classroom/archive.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Academic/classroom/show.css') }}" rel="stylesheet">
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
                <h4 class="mb-1 text-white font-weight-bold">{{ __('admin.classrooms.archived') }}</h4>
                <p class="mb-0 text-white-50 tx-13">{{ __('admin.classrooms.archived_list') }}</p>
            </div>
        </div>
        <div>
            <a href="{{ route('admin.classrooms.index') }}" class="btn btn-light shadow-sm" style="border-radius: 8px; font-weight: 600;">
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
            <p class="text-muted mb-0 tx-13">{{__('admin.grades.warning_body')}}</p>
        </div>
    </div>
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card glass-card-archive">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="grade_filter" class="form-label font-weight-bold">{{ __('admin.classrooms.fields.grade') }}:</label>
                            <select id="grade_filter" class="form-control select2">
                                <option value="">{{ __('admin.global.all') }}</option>
                                @foreach($grades as $grade)
                                    <option value="{{ $grade->name }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-archive table-hover" id="archivedClassroomsTable">
                            <thead>
                            <tr>
                                <th class="wd-5p border-bottom-0">#</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.name') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.classrooms.fields.grade') }}</th>
                                <th class="wd-10p border-bottom-0">{{ __('admin.classrooms.fields.status') }}</th>
                                <th class="wd-20p border-bottom-0">{{ __('admin.global.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classrooms as $classroom)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $classroom->name }}</td>
                                    <td>{{ $classroom->grade->name }}</td>
                                    <td>
                                        @if ($classroom->status)
                                            <span class="label text-success d-flex">{{ __('admin.global.active') }}</span>
                                        @else
                                            <span class="label text-danger d-flex">{{ __('admin.global.disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm view-btn"
                                           href="#"
                                           data-toggle="modal"
                                           data-target="#showModal"
                                           data-name="{{ $classroom->name }}"
                                           data-grade="{{ $classroom->grade->name }}"
                                           data-status="{{ $classroom->status }}"
                                           data-status_text="{{ $classroom->status ? __('admin.global.active') : __('admin.global.disabled') }}"
                                           data-notes="{{ $classroom->notes ?? __('admin.grades.no_notes') }}"
                                           data-sections='{!! json_encode($classroom->sections) !!}'
                                        >
                                            <i class="las la-eye"></i> {{__('admin.global.view')}}
                                        </a>
                                        @can('restore_classrooms')
                                        <a class="btn btn-sm btn-archive-restore restore-item"
                                        href="#"
                                           data-url="{{ route('admin.classrooms.restore', $classroom->id) }}"
                                           data-id="{{ $classroom->id }}"
                                           data-name="{{ $classroom->name }}"
                                        >
                                            <i class="las la-store"></i> {{__('admin.global.restore')}}
                                        </a>
                                        @endcan
                                        @can('delete_classrooms')
                                            <a class="btn btn-sm btn-archive-delete delete-item"
                                               href="#"
                                               data-id="{{ $classroom->id }}"
                                               data-url="{{ route('admin.classrooms.forceDelete', $classroom->id) }}"
                                               data-name="{{ $classroom->name }}">
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

    @include('admin.classrooms.show_modal')
@endsection

@section('js')
    <script src="{{URL::asset('assets/admin/js/crud.js')}}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')
    @include('admin.layouts.scripts.restore_script')

    <script>
        $(document).ready(function() {
            var table = $('#archivedClassroomsTable').DataTable(globalTableConfig);

            $('.select2').select2({
                placeholder: '{{__("admin.global.select")}}',
                width: '100%'
            });

            $('#grade_filter').on('change', function() {
                var selectedGrade = $(this).val();
                if (selectedGrade) {
                    table.column(2).search('^' + selectedGrade + '$', true, false).draw();
                } else {
                    table.column(2).search('').draw();
                }
            });
        });
    </script>
    @stack('scripts')
@endsection
