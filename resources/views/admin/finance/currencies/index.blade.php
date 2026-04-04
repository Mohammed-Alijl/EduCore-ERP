@extends('admin.layouts.master')

@section('title', trans('admin.finance.currencies.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Finance/finance-crud.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Finance/currency-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.finance.currencies.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_currencies')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addCurrencyModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.finance.currencies.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card glass-card">
                <div class="card-header pb-0"></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover" id="currencies_table">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-10p border-bottom-0">{{ trans('admin.finance.currencies.fields.code') }}
                                    </th>
                                    <th class="wd-25p border-bottom-0">{{ trans('admin.finance.currencies.fields.name') }}
                                    </th>
                                    <th class="wd-15p border-bottom-0">
                                        {{ trans('admin.finance.currencies.fields.exchange_rate') }}</th>
                                    <th class="wd-10p border-bottom-0">
                                        {{ trans('admin.finance.currencies.fields.is_default') }}</th>
                                    <th class="wd-10p border-bottom-0">
                                        {{ trans('admin.finance.currencies.fields.status') }}</th>
                                    <th class="wd-15p border-bottom-0 text-center">{{ trans('admin.global.actions') }}</th>
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
    @include('admin.finance.currencies.add_modal')
    @include('admin.finance.currencies.edit_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(document).ready(function() {
            var table = $('#currencies_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: "{{ route('admin.currencies.datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'exchange_rate',
                        name: 'exchange_rate'
                    },
                    {
                        data: 'is_default',
                        name: 'is_default',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
            });

            // ─── Populate Edit Modal ───────────────────────────────────────────────
            $(document).on('click', '.edit-btn', function() {
                var btn = $(this);
                var modal = $('#editCurrencyModal');

                modal.find('form').attr('action', btn.data('url'));
                modal.find('input[name="code"]').val(btn.data('code'));
                modal.find('input[name="name[ar]"]').val(btn.data('name_ar'));
                modal.find('input[name="name[en]"]').val(btn.data('name_en'));
                modal.find('input[name="exchange_rate"]').val(btn.data('exchange_rate'));
                modal.find('input[name="sort_order"]').val(btn.data('sort_order'));

                modal.find('input[name="is_default"]').val(btn.data('is_default') ? '1' : '0');
                modal.find('input[id="edit_is_default"]').prop('checked', btn.data('is_default') == 1);

                modal.find('input[name="status"]').val(btn.data('status') ? '1' : '0');
                modal.find('input[id="edit_status"]').prop('checked', btn.data('status') == 1);

                modal.modal('show');
            });

            // ─── Sync hidden inputs with checkboxes ───────────────────────────────
            $('#edit_is_default').on('change', function() {
                $(this).closest('form').find('input[name="is_default"]').val(this.checked ? '1' : '0');
            });

            $('#edit_status').on('change', function() {
                $(this).closest('form').find('input[name="status"]').val(this.checked ? '1' : '0');
            });

            $('#add_is_default').on('change', function() {
                $(this).closest('form').find('input[name="is_default"]').val(this.checked ? '1' : '0');
            });

            $('#add_status').on('change', function() {
                $(this).closest('form').find('input[name="status"]').val(this.checked ? '1' : '0');
            });
        });
    </script>
@endsection
