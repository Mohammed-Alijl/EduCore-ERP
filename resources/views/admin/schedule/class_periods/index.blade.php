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
    <style>
        .class-period-page .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .class-period-page .glass-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .class-period-page .glass-card-body {
            padding: 1.5rem;
        }

        .class-period-page .card-title-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #fff;
            margin-left: 1rem;
        }

        .class-period-page .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .class-period-page .bg-gradient-info {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .class-period-page .card-title-text h5 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
            color: #2d3748;
        }

        .class-period-page .card-title-text span {
            font-size: 0.85rem;
            color: #718096;
        }

        .class-period-page .filter-label {
            font-weight: 500;
            color: #4a5568;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .class-period-page .filter-label i {
            color: #667eea;
        }

        .class-period-page .filter-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .class-period-page .btn-filter-reset {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            color: #4a5568;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .class-period-page .btn-filter-reset:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        .class-period-page .btn-filter-search {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #fff;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .class-period-page .btn-filter-search:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .class-period-page .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: linear-gradient(135deg, #e6f2ff 0%, #e8f4f8 100%);
            color: #3182ce;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .class-period-page .duration-badge {
            background: #f0fff4;
            color: #38a169;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .class-period-page .action-buttons {
            display: flex;
            gap: 0.35rem;
            justify-content: center;
        }

        .class-period-page .action-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .class-period-page .action-btn:hover {
            transform: translateY(-2px);
        }

        .class-period-page .badge-primary-light {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
        }

        .class-period-page .badge-secondary-light {
            background: rgba(113, 128, 150, 0.15);
            color: #718096;
        }

        .class-period-page .badge-success-light {
            background: rgba(56, 161, 105, 0.15);
            color: #38a169;
        }

        .class-period-page .badge-warning-light {
            background: rgba(237, 137, 54, 0.15);
            color: #ed8936;
        }

        .class-period-page .avatar-initial {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
        }
    </style>
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
