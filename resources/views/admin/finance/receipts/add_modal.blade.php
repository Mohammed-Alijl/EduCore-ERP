<!-- ═══════════════════════════════════════════════════
     Add Receipt Modal
═══════════════════════════════════════════════════ -->
<div class="modal fade" id="addReceiptModal" tabindex="-1" role="dialog" aria-labelledby="addReceiptLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header receipt-add-header">
                <h5 class="modal-title font-weight-bold" id="addReceiptLabel">
                    <i class="las la-receipt tx-20 mr-2 ml-1"></i>
                    {{ trans('admin.finance.receipts.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.receipts.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addReceiptModal" data-parsley-validate="">
                @csrf

                <div class="modal-body p-4">

                    <!-- Invoice Reference Field -->
                    <div class="form-group receipt-form-group">
                        <label class="receipt-form-label">
                            <i class="las la-file-invoice-dollar text-primary"></i>
                            {{ trans('admin.finance.receipts.fields.invoice') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select name="invoice_id" class="form-control form-control-modern select2-modal" required
                            data-placeholder="{{ trans('admin.global.select') }}">
                            <option value=""></option>
                            @foreach ($invoices as $invoice)
                                <option value="{{ $invoice->id }}"
                                    data-amount="{{ number_format($invoice->amount, 2) }}">
                                    INV-#{{ $invoice->id }} —
                                    {{ $invoice->student->name ?? '—' }} —
                                    ${{ number_format($invoice->amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text invoice_id_error"></span>
                    </div>

                    <!-- Amount Preview (read-only, pulled from selected invoice) -->
                    <div class="form-group receipt-form-group">
                        <label class="receipt-form-label">
                            <i class="las la-money-bill-wave text-success"></i>
                            {{ trans('admin.finance.receipts.fields.amount') }}
                        </label>
                        <div class="receipt-amount-preview">
                            <div class="receipt-amount-preview-icon">
                                <i class="las la-check-circle"></i>
                            </div>
                            <div>
                                <div>
                                    <span id="receipt-amount-display" class="receipt-amount-value">0.00</span>
                                    <span class="receipt-amount-currency">{{ trans('admin.finance.receipts.currency') }}</span>
                                </div>
                                <small class="text-muted d-block" style="font-size:0.75rem; margin-top:0.25rem;">
                                    <i class="las la-info-circle mr-1"></i>
                                    {{ trans('admin.finance.invoices.amount_auto_note') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Field -->
                    <div class="form-group receipt-form-group">
                        <label class="receipt-form-label">
                            <i class="las la-credit-card text-primary"></i>
                            {{ trans('admin.finance.receipts.fields.payment_method') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select name="payment_method" class="form-control form-control-modern select2-modal" required
                            data-placeholder="{{ trans('admin.global.select') }}">
                            <option value=""></option>
                            <option value="cash">
                                {{ trans('admin.finance.receipts.payment_methods.cash') }}
                            </option>
                            <option value="bank_transfer">
                                {{ trans('admin.finance.receipts.payment_methods.bank_transfer') }}
                            </option>
                            <option value="cheque">
                                {{ trans('admin.finance.receipts.payment_methods.cheque') }}
                            </option>
                            <option value="online">
                                {{ trans('admin.finance.receipts.payment_methods.online') }}
                            </option>
                        </select>
                        <span class="text-danger error-text payment_method_error"></span>
                    </div>

                    <!-- Notes Field -->
                    <div class="form-group receipt-form-group">
                        <label class="receipt-form-label">
                            <i class="las la-sticky-note text-warning"></i>
                            {{ trans('admin.finance.receipts.fields.description') }}
                            <span class="text-muted font-weight-normal ml-1"
                                style="font-size:0.75rem;">({{ trans('admin.global.optional') }})</span>
                        </label>
                        <textarea class="form-control form-control-modern" name="description" rows="3" maxlength="500"
                            placeholder="{{ trans('admin.finance.receipts.fields.description') }}"></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>

                </div>

                <div class="modal-footer" style="background:#fff; border-top:1px solid #e2e8f0; gap:0.5rem;">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                        <i class="las la-times mr-1"></i>{{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-save-receipt">
                        <span class="spinner-border spinner-border-sm d-none mr-1"></span>
                        <i class="las la-receipt mr-1"></i>{{ trans('admin.global.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
