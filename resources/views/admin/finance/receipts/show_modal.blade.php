<!-- ═══════════════════════════════════════════════════
     Show Receipt Modal — Premium Card Layout
═══════════════════════════════════════════════════ -->
<div class="modal fade" id="showReceiptModal" tabindex="-1" role="dialog" aria-labelledby="showReceiptLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Gradient Header -->
            <div class="modal-header receipt-show-header">
                <div class="d-flex align-items-center">
                    <div class="receipt-show-icon">
                        <i class="las la-receipt tx-26"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="modal-title mb-0 font-weight-bold text-white" id="showReceiptLabel">
                            {{ trans('admin.finance.receipts.show') }}
                        </h5>
                        <small class="text-white-50" id="show-receipt-number">—</small>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">

                <!-- ── AMOUNT HERO CARD ──────────────────────────────────────── -->
                <div class="receipt-amount-hero mb-4">
                    <div class="row align-items-center no-gutters">
                        <div class="col">
                            <span class="receipt-hero-label">{{ trans('admin.finance.receipts.fields.amount') }}</span>
                            <div class="receipt-hero-amount" id="show-receipt-amount">0.00</div>
                            <small class="text-white-50">{{ trans('admin.finance.receipts.currency') }}</small>
                        </div>
                        <div class="col-auto text-right">
                            <div class="receipt-hero-date">
                                <i class="las la-calendar-alt mr-1"></i>
                                <span id="show-receipt-hero-date">—</span>
                            </div>
                            <div class="mt-2" id="show-receipt-payment-badge-container"></div>
                        </div>
                    </div>
                </div>

                <!-- ── STUDENT CARD ──────────────────────────────────────────── -->
                <div class="receipt-section-title">
                    <i class="las la-user-graduate"></i>
                    {{ trans('admin.finance.receipts.fields.student') }}
                </div>
                <div class="receipt-info-card mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="receipt-field">
                                <span class="receipt-field-label">{{ trans('admin.global.name') }}</span>
                                <span class="receipt-field-value" id="show-student-name">—</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="receipt-field">
                                <span class="receipt-field-label">{{ trans('admin.global.code') }}</span>
                                <span class="receipt-field-value" id="show-student-code">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── PAYMENT DETAILS CARD ──────────────────────────────────── -->
                <div class="receipt-section-title">
                    <i class="las la-money-check-alt"></i>
                    {{ trans('admin.finance.receipts.fields.payment_method') }}
                </div>
                <div class="receipt-info-card mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="receipt-field">
                                <span class="receipt-field-label">{{ trans('admin.finance.receipts.fields.invoice') }}</span>
                                <span class="receipt-field-value" id="show-invoice-ref">—</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="receipt-field">
                                <span class="receipt-field-label">{{ trans('admin.finance.receipts.fields.academic_year') }}</span>
                                <span class="receipt-field-value" id="show-academic-year">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── NOTES CARD ──────────────────────────────────────────── -->
                <div class="receipt-section-title">
                    <i class="las la-sticky-note"></i>
                    {{ trans('admin.finance.receipts.fields.description') }}
                </div>
                <div class="receipt-info-card mb-0">
                    <p class="mb-0 receipt-field-value" id="show-receipt-description">—</p>
                </div>

            </div>

            <div class="modal-footer receipt-show-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                    <i class="las la-times mr-1"></i>{{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '.view-receipt-btn', function (e) {
            e.preventDefault();
            var btn = $(this);

            var paymentMethod   = btn.data('payment_method') || '';
            var paymentLabels   = {
                cash:          '{{ trans('admin.finance.receipts.payment_methods.cash') }}',
                bank_transfer: '{{ trans('admin.finance.receipts.payment_methods.bank_transfer') }}',
                cheque:        '{{ trans('admin.finance.receipts.payment_methods.cheque') }}',
                online:        '{{ trans('admin.finance.receipts.payment_methods.online') }}',
            };
            var badgeClasses    = {
                cash:          'receipt-badge receipt-badge-cash',
                bank_transfer: 'receipt-badge receipt-badge-transfer',
                cheque:        'receipt-badge receipt-badge-cheque',
                online:        'receipt-badge receipt-badge-online',
            };
            var methodIcons     = {
                cash:          'la-money-bill-wave',
                bank_transfer: 'la-university',
                cheque:        'la-file-alt',
                online:        'la-credit-card',
            };

            // Header
            $('#show-receipt-number').text(btn.data('receipt_number') || '—');
            $('#show-receipt-hero-date').text(btn.data('receipt_date') || '—');
            $('#show-receipt-amount').text(btn.data('amount') || '0.00');

            // Payment method badge inside hero
            var badgeCls  = badgeClasses[paymentMethod]  || 'receipt-badge';
            var iconCls   = methodIcons[paymentMethod]   || 'la-money-bill-wave';
            var badgeLabel = paymentLabels[paymentMethod] || paymentMethod;
            $('#show-receipt-payment-badge-container').html(
                '<span class="' + badgeCls + '" style="background:rgba(255,255,255,.15);color:#fff;border-color:rgba(255,255,255,.3);">' +
                '<i class="las ' + iconCls + ' mr-1"></i>' + badgeLabel + '</span>'
            );

            // Student
            $('#show-student-name').text(btn.data('student_name') || '—');
            $('#show-student-code').text(btn.data('student_code') || '—');

            // Payment details
            $('#show-invoice-ref').text('INV-#' + (btn.data('invoice_id') || '—'));
            $('#show-academic-year').text(btn.data('academic_year') || '—');

            // Notes
            var desc = btn.data('description');
            $('#show-receipt-description').text(desc ? desc : '{{ trans('admin.global.no_description') }}');

            $('#showReceiptModal').modal('show');
        });
    </script>
@endpush
