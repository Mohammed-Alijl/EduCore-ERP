@extends('admin.layouts.master')

@section('title', trans('admin.Finance.receipts.title'))

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Finance/receipts/receipt-crud.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{ trans('admin.sidebar.finance') }}</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ trans('admin.Finance.receipts.title') }}</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            @can('create_receipts')
                <div class="mb-3 mb-xl-0 ml-2">
                    <a class="modal-effect btn btn-primary btn-modern shadow-sm" data-effect="effect-scale" data-toggle="modal"
                        href="#addReceiptModal">
                        <i class="las la-plus-circle tx-18 mr-1 ml-1"></i>
                        {{ trans('admin.Finance.receipts.add') }}
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    @php
        $lookups = $lookups ?? [
            'academic_years' => $academic_years ?? collect(),
            'payment_gateways' => $payment_gateways ?? collect(),
            'offline_payment_gateways' => $offline_payment_gateways ?? collect(),
            'currencies' => $currencies ?? collect(),
        ];
    @endphp

    <div class="row row-sm receipt-page">
        <div class="col-12">
            <div class="card glass-card overflow-hidden">
                <div class="card-header border-0 pb-0">
                    <h5 class="mb-1 font-weight-bold">
                        {{ trans('admin.Finance.receipts.title') }}
                    </h5>
                    <p class="mb-0 text-muted tx-13">
                        {{ trans('admin.global.search') }} • {{ trans('admin.global.filters') }} •
                        {{ trans('admin.global.actions') }}
                    </p>

                    <div class="filter-section mt-4 mb-2">
                        <div class="row align-items-end p-3">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-user-graduate mr-1"></i>
                                    {{ trans('admin.Finance.receipts.fields.student') }}
                                </label>
                                <select class="form-control form-control-modern" id="filter_student"
                                    data-placeholder="{{ trans('admin.global.all') }}">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3 mb-md-0">
                                <label class="form-label tx-11 font-weight-bold text-uppercase text-muted">
                                    <i class="las la-credit-card mr-1"></i>
                                    {{ trans('admin.Finance.receipts.fields.payment_gateway') }}
                                </label>
                                <select class="form-control form-control-modern select2-filter" id="filter_payment_gateway">
                                    <option value="">{{ trans('admin.global.all') }}</option>
                                    @foreach ($lookups['payment_gateways'] as $gateway)
                                        <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 text-right">
                                <button class="btn btn-modern btn-outline-primary w-100" id="reset_filters">
                                    <i class="las la-sync-alt mr-1 ml-1"></i>
                                    {{ trans('admin.global.reset_filters') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table id="receipts_table" class="table table-hover text-md-nowrap mb-0" width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p border-bottom-0">#</th>
                                    <th class="wd-20p border-bottom-0">{{ trans('admin.Finance.receipts.fields.student') }}
                                    </th>
                                    <th class="wd-20p border-bottom-0">
                                        {{ trans('admin.Finance.receipts.fields.payment_gateway') }}</th>
                                    <th class="wd-25p border-bottom-0">
                                        {{ trans('admin.Finance.receipts.fields.amount_details') }}</th>
                                    <th class="wd-15p border-bottom-0">{{ trans('admin.Finance.receipts.fields.date') }}
                                    </th>
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
    @include('admin.Finance.receipts.add_modal')
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/admin/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script
        src="{{ URL::asset('assets/admin/plugins/parsleyjs/i18n/' . LaravelLocalization::getCurrentLocale() . '.js') }}">
    </script>
    <script src="{{ URL::asset('assets/admin/js/crud.js') }}"></script>

    @include('admin.layouts.scripts.datatable_config')
    @include('admin.layouts.scripts.delete_script')

    <script>
        $(function() {
            const addReceiptModal = $('#addReceiptModal');
            const filterStudent = $('#filter_student');
            const filterPaymentGateway = $('#filter_payment_gateway');
            const resetFilters = $('#reset_filters');
            const receiptsTable = $('#receipts_table').DataTable({
                ...globalTableConfig,
                processing: true,
                serverSide: true,
                language: $.extend({}, datatable_lang),
                ajax: {
                    url: '{{ route('admin.Finance.receipts.datatable') }}',
                    data: function(d) {
                        d.student_id = filterStudent.val();
                        d.payment_gateway_id = filterPaymentGateway.val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student',
                        name: 'student',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'date',
                        name: 'date'
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

            $('.select2-modal').select2({
                width: '100%',
                placeholder: '{{ trans('admin.global.select') }}',
                dropdownParent: addReceiptModal
            });

            $('.select2-filter').select2({
                width: '100%',
                allowClear: true
            });

            filterStudent.select2({
                width: '100%',
                allowClear: true,
                placeholder: '{{ trans('admin.global.all') }}',
                minimumInputLength: 0,
                ajax: {
                    url: '{{ route('admin.Users.students.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.results || [],
                            pagination: {
                                more: response.pagination && response.pagination.more === true
                            }
                        };
                    }
                }
            });

            $('#student_id').select2({
                width: '100%',
                allowClear: true,
                placeholder: '{{ trans('admin.global.select') }}',
                minimumInputLength: 2,
                dropdownParent: addReceiptModal,
                ajax: {
                    url: '{{ route('admin.Users.students.search') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term || '',
                            page: params.page || 1
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response.results || [],
                            pagination: {
                                more: response.pagination && response.pagination.more === true
                            }
                        };
                    }
                }
            });

            filterStudent.add(filterPaymentGateway).on('change', function() {
                receiptsTable.draw();
            });

            resetFilters.on('click', function(e) {
                e.preventDefault();
                filterStudent.val(null).trigger('change.select2');
                filterPaymentGateway.val('').trigger('change.select2');
                receiptsTable.draw();
            });

            addReceiptModal.on('hidden.bs.modal', function() {
                const $form = $(this).find('form');
                if ($form.length) {
                    $form[0].reset();
                }

                $(this).find('.error-text').text('');
                $(this).find('input, select, textarea').removeClass('is-invalid');
                $('#student_id').val(null).trigger('change');
                $('.select2-modal').val(null).trigger('change');
                $('#transaction_id').prop('readonly', false).prop('required', false);
                $('label[for="transaction_id"]').find('.text-danger').remove();
            });

            // Toggle transaction ID requirement based on gateway selection
            $('#payment_gateway_id').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var gatewayCode = selectedOption.data('code');
                var $transactionInput = $('#transaction_id');
                var $transactionLabel = $('label[for="transaction_id"]');

                if (gatewayCode === 'bank_transfer') {
                    $transactionInput.prop('readonly', false).prop('required', true);
                    if ($transactionLabel.find('.text-danger').length === 0) {
                        $transactionLabel.append(' <span class="text-danger">*</span>');
                    }
                } else {
                    $transactionInput.prop('readonly', true).prop('required', false).val('');
                    $transactionLabel.find('.text-danger').remove();
                    $transactionInput.removeClass('parsley-error is-invalid');
                    $('.transaction_id_error').text('');
                }
            });
        });
    </script>
@endsection
