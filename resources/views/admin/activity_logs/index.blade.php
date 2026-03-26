@extends('admin.layouts.master')

@section('title', trans('admin.activity_logs.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
    <style>
        .log-badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
            border-radius: 0.25rem;
        }

        .log-badge-created {
            background-color: #28a745;
            color: #fff;
        }

        .log-badge-updated {
            background-color: #ffc107;
            color: #212529;
        }

        .log-badge-deleted {
            background-color: #dc3545;
            color: #fff;
        }

        .log-badge-default {
            background-color: #6c757d;
            color: #fff;
        }

        .log-name-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
            border-radius: 0.2rem;
        }

        .subject-info {
            line-height: 1.4;
        }

        .causer-info {
            line-height: 1.4;
        }

        .stats-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stats-icon-created {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .stats-icon-updated {
            background: rgba(255, 193, 7, 0.15);
            color: #d39e00;
        }

        .stats-icon-deleted {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .stats-icon-total {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
        }
    </style>
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.reports_settings') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.activity_logs.title') }}</span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- Statistics Cards --}}
    <div class="row mb-4" id="stats-container">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon stats-icon-total me-3 ml-3">
                        <i class="las la-history"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 tx-12">{{ trans('admin.activity_logs.stats.total') }}</p>
                        <h4 class="mb-0 font-weight-bold" id="stat-total">--</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon stats-icon-created me-3 ml-3">
                        <i class="las la-plus-circle"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 tx-12">{{ trans('admin.activity_logs.stats.created') }}</p>
                        <h4 class="mb-0 font-weight-bold text-success" id="stat-created">--</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon stats-icon-updated me-3 ml-3">
                        <i class="las la-edit"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 tx-12">{{ trans('admin.activity_logs.stats.updated') }}</p>
                        <h4 class="mb-0 font-weight-bold text-warning" id="stat-updated">--</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card stats-card h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="stats-icon stats-icon-deleted me-3 ml-3">
                        <i class="las la-trash-alt"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 tx-12">{{ trans('admin.activity_logs.stats.deleted') }}</p>
                        <h4 class="mb-0 font-weight-bold text-danger" id="stat-deleted">--</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="row row-sm">
        <div class="col-12">
            <div class="card glass-card overflow-hidden">
                <div class="card-header border-0 pb-0">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1 font-weight-bold">{{ trans('admin.activity_logs.title') }}</h5>
                            <p class="mb-0 text-muted tx-13">
                                {{ trans('admin.activity_logs.subtitle') }}
                            </p>
                        </div>
                    </div>

                    {{-- Advanced Filter Section --}}
                    <div class="filter-section mt-4 mb-2">
                        <div class="row align-items-end p-3">
                            {{-- Log Name --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-tag mr-1"></i> {{ trans('admin.activity_logs.fields.log_name') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_log_name">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($logNames as $logName)
                                        <option value="{{ $logName }}">{{ $logName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Event Type --}}
                            <div class="col-md-2 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-bolt mr-1"></i> {{ trans('admin.activity_logs.fields.event') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_event">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}">{{ ucfirst($event) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Date Range --}}
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-calendar mr-1"></i>
                                    {{ trans('admin.activity_logs.fields.date_range') }}
                                </label>
                                <input type="text" class="form-control form-control-modern" id="filter_date_range"
                                    placeholder="{{ trans('admin.activity_logs.fields.select_date_range') }}" readonly>
                            </div>

                            {{-- Search --}}
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-search mr-1"></i> {{ trans('admin.global.search') }}
                                </label>
                                <input type="text" class="form-control form-control-modern" id="filter_search"
                                    placeholder="{{ trans('admin.activity_logs.fields.search_placeholder') }}">
                            </div>

                            {{-- Reset Button --}}
                            <div class="col-md-2 text-right">
                                <button class="btn btn-modern w-100 btn-outline-primary" id="reset_filters">
                                    <i class="las la-sync-alt mr-1 ml-1"></i>
                                    {{ trans('admin.global.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover mb-0" id="activity_logs_table" width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-12p border-bottom-0">{{ trans('admin.activity_logs.fields.log_name') }}
                                    </th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.activity_logs.fields.event') }}
                                    </th>
                                    <th class="wd-20p border-bottom-0">
                                        {{ trans('admin.activity_logs.fields.description') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.activity_logs.fields.subject') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.activity_logs.fields.causer') }}
                                    </th>
                                    <th class="wd-13p border-bottom-0">
                                        {{ trans('admin.activity_logs.fields.created_at') }}</th>
                                    <th class="wd-10p border-bottom-0 text-center">{{ trans('admin.global.actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Details Modal --}}
    @include('admin.activity_logs.partials.details_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(function() {
            var datatableUrl = '{{ route('admin.activity_logs.datatable') }}';
            var statisticsUrl = '{{ route('admin.activity_logs.statistics') }}';
            var showUrl = '{{ route('admin.activity_logs.show', ':id') }}';

            var elements = {
                filterLogName: $('#filter_log_name'),
                filterEvent: $('#filter_event'),
                filterDateRange: $('#filter_date_range'),
                filterSearch: $('#filter_search'),
                resetFilters: $('#reset_filters'),
                detailsModal: $('#logDetailsModal')
            };

            var dateRangeConfig = {
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: '{{ trans('admin.global.cancel') }}',
                    applyLabel: '{{ trans('admin.global.ok') }}',
                    fromLabel: '{{ trans('admin.activity_logs.fields.from') }}',
                    toLabel: '{{ trans('admin.activity_logs.fields.to') }}'
                },
                ranges: {
                    '{{ trans('admin.activity_logs.date_ranges.today') }}': [moment(), moment()],
                    '{{ trans('admin.activity_logs.date_ranges.yesterday') }}': [moment().subtract(1, 'days'),
                        moment().subtract(1, 'days')
                    ],
                    '{{ trans('admin.activity_logs.date_ranges.last_7_days') }}': [moment().subtract(6,
                        'days'), moment()
                    ],
                    '{{ trans('admin.activity_logs.date_ranges.last_30_days') }}': [moment().subtract(29,
                        'days'), moment()],
                    '{{ trans('admin.activity_logs.date_ranges.this_month') }}': [moment().startOf('month'),
                        moment().endOf('month')
                    ],
                    '{{ trans('admin.activity_logs.date_ranges.last_month') }}': [moment().subtract(1, 'month')
                        .startOf('month'), moment().subtract(1, 'month').endOf('month')
                    ]
                }
            };

            initializeComponents();
            loadStatistics();

            var table = $('#activity_logs_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                order: [
                    [6, 'desc']
                ],
                ajax: {
                    url: datatableUrl,
                    data: function(d) {
                        $.extend(d, getTableFilters());
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'log_name',
                        name: 'log_name',
                        orderable: true
                    },
                    {
                        data: 'event',
                        name: 'event',
                        orderable: true
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false
                    },
                    {
                        data: 'subject',
                        name: 'subject',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'causer',
                        name: 'causer',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        orderable: true
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Event Listeners
            elements.filterLogName.on('change', refreshTable);
            elements.filterEvent.on('change', refreshTable);
            elements.filterSearch.on('keyup', debounce(refreshTable, 500));
            elements.resetFilters.on('click', resetFilters);

            elements.filterDateRange.on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                    'YYYY-MM-DD'));
                refreshTable();
            });

            elements.filterDateRange.on('cancel.daterangepicker', function() {
                $(this).val('');
                refreshTable();
            });

            // View Details
            $(document).on('click', '.btn-view-log', function() {
                var logId = $(this).data('id');
                loadLogDetails(logId);
            });

            function initializeComponents() {
                $('.select2-filter').select2({
                    width: '100%',
                    allowClear: true
                });

                elements.filterDateRange.daterangepicker(dateRangeConfig);
            }

            function getTableFilters() {
                var dates = elements.filterDateRange.val().split(' - ');
                return {
                    log_name: elements.filterLogName.val(),
                    event: elements.filterEvent.val(),
                    start_date: dates[0] || '',
                    end_date: dates[1] || '',
                    search: elements.filterSearch.val()
                };
            }

            function refreshTable() {
                table.draw();
                loadStatistics();
            }

            function resetFilters() {
                elements.filterLogName.val('').trigger('change.select2');
                elements.filterEvent.val('').trigger('change.select2');
                elements.filterDateRange.val('');
                elements.filterSearch.val('');
                refreshTable();
            }

            function loadStatistics() {
                $.ajax({
                    url: statisticsUrl,
                    method: 'GET',
                    data: getTableFilters(),
                    success: function(response) {
                        if (response.status === 'success') {
                            updateStatisticsDisplay(response.data);
                        }
                    }
                });
            }

            function updateStatisticsDisplay(stats) {
                $('#stat-total').text(stats.total_logs || 0);
                $('#stat-created').text(stats.by_event?.created || 0);
                $('#stat-updated').text(stats.by_event?.updated || 0);
                $('#stat-deleted').text(stats.by_event?.deleted || 0);
            }

            function loadLogDetails(logId) {
                var url = showUrl.replace(':id', logId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    beforeSend: function() {
                        elements.detailsModal.find('.modal-body').html(
                            '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>'
                        );
                        elements.detailsModal.modal('show');
                    },
                    success: function(response) {
                        elements.detailsModal.find('.modal-body').html(response);
                    },
                    error: function() {
                        elements.detailsModal.find('.modal-body').html(
                            '<div class="alert alert-danger">{{ trans('admin.global.error_loading') }}</div>'
                        );
                    }
                });
            }

            function debounce(func, wait) {
                var timeout;
                return function() {
                    var context = this,
                        args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        func.apply(context, args);
                    }, wait);
                };
            }
        });
    </script>
@endsection
