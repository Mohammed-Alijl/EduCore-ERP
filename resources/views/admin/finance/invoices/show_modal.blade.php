<!-- ═══════════════════════════════════════════════════
     Show Invoice Modal — Card Style
═══════════════════════════════════════════════════ -->
<div class="modal fade" id="showInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="showInvoiceLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <!-- Gradient Header -->
            <div class="modal-header invoice-show-header">
                <div class="d-flex align-items-center">
                    <div class="invoice-show-icon">
                        <i class="las la-file-invoice tx-26"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="modal-title mb-0 font-weight-bold text-white" id="showInvoiceLabel">
                            {{ trans('admin.finance.invoices.show') }}
                        </h5>
                        <small class="text-white-50" id="show-invoice-number">—</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">

                <!-- ── AMOUNT HERO CARD ──────────────────────────────────────── -->
                <div class="invoice-amount-hero mb-4">
                    <div class="row align-items-center no-gutters">
                        <div class="col">
                            <span class="invoice-hero-label">{{ trans('admin.finance.invoices.fields.amount') }}</span>
                            <div class="invoice-hero-amount" id="show-invoice-amount">0.00</div>
                            <small class="text-white-50">{{ trans('admin.finance.invoices.currency') }}</small>
                        </div>
                        <div class="col-auto text-right">
                            <div class="invoice-hero-date">
                                <i class="las la-calendar-alt mr-1"></i>
                                <span id="show-invoice-hero-date">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── STUDENT CARD ──────────────────────────────────────────── -->
                <div class="invoice-section-title">
                    <i class="las la-user-graduate"></i>
                    {{ trans('admin.finance.invoices.fields.student') }}
                </div>
                <div class="invoice-info-card mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="invoice-field">
                                <span class="invoice-field-label">{{ trans('admin.global.name') }}</span>
                                <span class="invoice-field-value" id="show-student-name">—</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="invoice-field">
                                <span class="invoice-field-label">{{ trans('admin.global.code') }}</span>
                                <span class="invoice-field-value" id="show-student-code">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── FEE CARD ──────────────────────────────────────────────── -->
                <div class="invoice-section-title">
                    <i class="las la-receipt"></i>
                    {{ trans('admin.finance.invoices.fields.fee_details') }}
                </div>
                <div class="invoice-info-card mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="invoice-field">
                                <span class="invoice-field-label">{{ trans('admin.finance.fees.fields.title') }}</span>
                                <span class="invoice-field-value" id="show-fee-title">—</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="invoice-field">
                                <span
                                    class="invoice-field-label">{{ trans('admin.finance.fees.fields.category') }}</span>
                                <span class="invoice-field-value" id="show-fee-category">—</span>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="invoice-field">
                                <span class="invoice-field-label">{{ trans('admin.finance.invoices.fields.academic_year') }}</span>
                                <span class="invoice-field-value" id="show-academic-year">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── DESCRIPTION CARD ──────────────────────────────────────── -->
                <div class="invoice-section-title">
                    <i class="las la-sticky-note"></i>
                    {{ trans('admin.finance.invoices.fields.description') }}
                </div>
                <div class="invoice-info-card mb-0">
                    <p class="mb-0 invoice-field-value" id="show-invoice-description">—</p>
                </div>

            </div>

            <div class="modal-footer invoice-show-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                    <i class="las la-times mr-1"></i>{{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).on('click', '.view-invoice-btn', function(e) {
            e.preventDefault();
            var btn = $(this);

            // Header
            $('#show-invoice-number').text('INV-#' + (btn.data('id') || '—'));
            $('#show-invoice-hero-date').text(btn.data('invoice_date') || '—');

            $('#show-invoice-amount').text(btn.data('amount') || '0.00');

            $('#show-student-name').text(btn.data('student_name') || '—');
            $('#show-student-code').text(btn.data('student_code') || '—');

            $('#show-fee-title').text(btn.data('fee_title') || '—');
            $('#show-fee-category').text(btn.data('fee_category') || '—');
            $('#show-academic-year').text(btn.data('academic_year') || '—');

            var desc = btn.data('description');
            $('#show-invoice-description').text(desc ? desc : '{{ trans('admin.global.no_description') }}');

            $('#showInvoiceModal').modal('show');
        });
    </script>
@endpush
