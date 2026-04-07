<!-- ═══════════════════════════════════════════════════
     Add Invoice Modal
═══════════════════════════════════════════════════ -->
<div class="modal fade" id="addInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="addInvoiceLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header invoice-modal-header">
                <h5 class="modal-title font-weight-bold" id="addInvoiceLabel">
                    <i class="las la-file-invoice-dollar tx-20 mr-2 ml-1" style="color:#6366f1;"></i>
                    {{ trans('admin.Finance.invoices.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.Finance.invoices.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addInvoiceModal" data-parsley-validate="">
                @csrf

                <div class="modal-body p-4">

                    <!-- Student Field -->
                    <div class="form-group invoice-form-group">
                        <label class="invoice-form-label">
                            <i class="las la-user-graduate mr-1 text-primary"></i>
                            {{ trans('admin.Finance.invoices.fields.student') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select name="student_id" class="form-control form-control-modern select2-student-modal"
                            required data-placeholder="{{ trans('admin.global.select') }}">
                            <option value=""></option>
                        </select>
                        <span class="text-danger error-text student_id_error"></span>
                    </div>

                    <!-- Fee Field -->
                    <div class="form-group invoice-form-group">
                        <label class="invoice-form-label">
                            <i class="las la-receipt mr-1 text-primary"></i>
                            {{ trans('admin.Finance.invoices.fields.fee') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select name="fee_id" class="form-control form-control-modern select2-modal" required
                            data-placeholder="{{ trans('admin.global.select') }}">
                            <option value=""></option>
                            @foreach ($fees as $fee)
                                <option value="{{ $fee->id }}" data-amount="{{ number_format($fee->amount, 2) }}">
                                    {{ $fee->title }} — {{ number_format($fee->amount, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text fee_id_error"></span>
                    </div>

                    <!-- Amount Preview (read-only, snapshotted by backend) -->
                    <div class="form-group invoice-form-group">
                        <label class="invoice-form-label">
                            <i class="las la-money-bill-wave mr-1 text-success"></i>
                            {{ trans('admin.Finance.invoices.fields.amount') }}
                        </label>
                        <div class="invoice-amount-preview">
                            <span id="fee-amount-display" class="invoice-amount-value">0.00</span>
                            <span class="invoice-amount-currency">{{ trans('admin.Finance.invoices.currency') }}</span>
                            <small class="d-block text-muted mt-1">
                                <i
                                    class="las la-info-circle mr-1"></i>{{ trans('admin.Finance.invoices.amount_auto_note') }}
                            </small>
                        </div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group invoice-form-group">
                        <label class="invoice-form-label">
                            <i class="las la-sticky-note mr-1 text-warning"></i>
                            {{ trans('admin.Finance.invoices.fields.description') }}
                            <span class="text-muted font-weight-normal ml-1"
                                style="font-size:0.75rem;">({{ trans('admin.global.optional') }})</span>
                        </label>
                        <textarea class="form-control form-control-modern" name="description" rows="3" maxlength="500"
                            placeholder="{{ trans('admin.Finance.invoices.fields.description') }}"></textarea>
                        <span class="text-danger error-text description_error"></span>
                    </div>

                </div>

                <div class="modal-footer invoice-modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                        <i class="las la-times mr-1"></i>{{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn invoice-btn-save">
                        <span class="spinner-border spinner-border-sm d-none mr-1"></span>
                        <i class="las la-file-invoice mr-1"></i>{{ trans('admin.global.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
