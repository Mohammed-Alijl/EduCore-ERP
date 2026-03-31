@extends('admin.layouts.master')

@section('title', __('admin.class_periods.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/schedule/class-periods.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between class-period-page">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-clock"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ __('admin.class_periods.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ __('admin.class_periods.subtitle') }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_classPeriods')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-with-icon btn-block" data-effect="effect-scale"
                        data-toggle="modal" href="#createClassPeriodModal">
                        <i class="fas fa-plus-circle"></i> {{ __('admin.class_periods.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="class-period-page">
        <div class="row row-sm">
            <div class="col-xl-12">

                {{-- Filters Card --}}
                <div class="glass-card mb-4">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-primary">
                                <i class="las la-filter"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ __('admin.class_periods.filters.title') }}</h5>
                                <span>{{ __('admin.class_periods.filters.subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="row">
                            {{-- Grade Filter --}}
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-layer-group"></i> {{ __('admin.class_periods.filters.grade') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_grade" name="grade_id">
                                    <option value="">{{ __('admin.global.all') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Type Filter --}}
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-tags"></i> {{ __('admin.class_periods.filters.type') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_is_break"
                                    name="is_break">
                                    <option value="">{{ __('admin.global.all') }}</option>
                                    <option value="0">{{ __('admin.class_periods.class') }}</option>
                                    <option value="1">{{ __('admin.class_periods.break') }}</option>
                                </select>
                            </div>

                            {{-- Status Filter --}}
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="filter-label">
                                    <i class="las la-toggle-on"></i> {{ __('admin.class_periods.filters.status') }}
                                </label>
                                <select class="form-control form-control-modern select2" id="filter_status" name="status">
                                    <option value="">{{ __('admin.global.all') }}</option>
                                    <option value="1">{{ __('admin.global.active') }}</option>
                                    <option value="0">{{ __('admin.global.disabled') }}</option>
                                </select>
                            </div>
                        </div>

                        {{-- Filter Actions --}}
                        <div class="filter-actions">
                            <button type="button" class="btn btn-filter-reset" id="btn_reset_filters">
                                <i class="las la-eraser mr-1 ml-1"></i>
                                {{ __('admin.class_periods.filters.reset') }}
                            </button>
                            <button type="button" class="btn btn-filter-search" id="btn_filter_search">
                                <i class="las la-search mr-1 ml-1"></i>
                                {{ __('admin.class_periods.filters.search') }}
                            </button>
                        </div>
                    </div>
                </div>

                {{-- DataTable Card --}}
                <div class="glass-card">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-info">
                                <i class="las la-table"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ __('admin.class_periods.table.title') }}</h5>
                                <span>{{ __('admin.class_periods.table.subtitle') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="class_periods_table">
                                <thead>
                                    <tr>
                                        <th class="wd-5p border-bottom-0">#</th>
                                        <th class="wd-20p border-bottom-0">{{ __('admin.class_periods.fields.name') }}</th>
                                        <th class="wd-12p border-bottom-0">{{ __('admin.class_periods.fields.grade') }}
                                        </th>
                                        <th class="wd-18p border-bottom-0">
                                            {{ __('admin.class_periods.fields.time_range') }}</th>
                                        <th class="wd-10p border-bottom-0 text-center">
                                            {{ __('admin.class_periods.fields.duration') }}</th>
                                        <th class="wd-10p border-bottom-0 text-center">
                                            {{ __('admin.class_periods.fields.type') }}</th>
                                        <th class="wd-10p border-bottom-0 text-center">
                                            {{ __('admin.class_periods.fields.status') }}</th>
                                        @canany(['edit_classPeriods', 'delete_classPeriods'])
                                            <th class="wd-15p border-bottom-0 text-center">{{ __('admin.global.actions') }}
                                            </th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
 </div>
</div>
    @include('admin.schedule.class_periods.create_modal')
    @include('admin.schedule.class_periods.edit_modal')

@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {

            // Select2 Initialization
            $('.select2').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder') || '';
                }
            });

            // DataTable Initialization
            var classPeriodsTable = $('#class_periods_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: "{{ route('admin.schedule.class_periods.datatable') }}",
                    data: function(d) {
                        d.grade_id = $('#filter_grade').val();
                        d.is_break = $('#filter_is_break').val();
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'grade',
                        name: 'grade',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'time_range',
                        name: 'time_range',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        className: 'text-center'
                    },
                    {
                        data: 'type',
                        name: 'type',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    @canany(['edit_classPeriods', 'delete_classPeriods'])
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                    @endcanany
                ],
                order: [
                    [0, 'asc']
                ]
            });

            // Filter Button
            $('#btn_filter_search').on('click', function() {
                classPeriodsTable.draw();
            });

            // Reset Filters
            $('#btn_reset_filters').on('click', function() {
                $('#filter_grade').val('').trigger('change');
                $('#filter_is_break').val('').trigger('change');
                $('#filter_status').val('').trigger('change');
                classPeriodsTable.draw();
            });

            // Auto-calculate end time based on start time and duration
            function calculateEndTime(modal) {
                var startTime = modal.find('[name="start_time"]').val();
                var duration = modal.find('[name="duration"]').val();

                if (startTime && duration) {
                    var parts = startTime.split(':');
                    var startDate = new Date();
                    startDate.setHours(parseInt(parts[0]), parseInt(parts[1]), 0);
                    startDate.setMinutes(startDate.getMinutes() + parseInt(duration));

                    var endHours = String(startDate.getHours()).padStart(2, '0');
                    var endMinutes = String(startDate.getMinutes()).padStart(2, '0');
                    modal.find('[name="end_time"]').val(endHours + ':' + endMinutes);
                }
            }

            // Bind auto-calculate to create modal
            $('#createClassPeriodModal').on('change', '[name="start_time"], [name="duration"]', function() {
                calculateEndTime($('#createClassPeriodModal'));
            });

            // Bind auto-calculate to edit modal
            $('#editClassPeriodModal').on('change', '[name="start_time"], [name="duration"]', function() {
                calculateEndTime($('#editClassPeriodModal'));
            });

        });
    </script>
@endsection
