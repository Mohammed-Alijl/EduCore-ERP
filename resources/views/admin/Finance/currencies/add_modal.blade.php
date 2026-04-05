<div class="modal fade" id="addCurrencyModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-coins mr-2"></i>
                    {{ trans('admin.Finance.currencies.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.Finance.currencies.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addCurrencyModal" data-parsley-validate="">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        {{-- Code --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.Finance.currencies.fields.code') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="code"
                                    class="form-control form-control-modern text-uppercase" placeholder="USD"
                                    maxlength="3" required autocomplete="off"
                                    style="letter-spacing: 2px; font-weight: 600;">
                                <span class="text-danger error-text code_error"></span>
                            </div>
                        </div>

                        {{-- Exchange Rate --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.Finance.currencies.fields.exchange_rate') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="exchange_rate" class="form-control form-control-modern"
                                    placeholder="1.0000" step="0.0001" min="0.0001" max="999999" value="1.0000"
                                    required>
                                <span class="text-danger error-text exchange_rate_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Name Arabic --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.Finance.currencies.fields.name_ar') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name[ar]" class="form-control form-control-modern"
                                    placeholder="{{ trans('admin.Finance.currencies.fields.name_ar') }}" required
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        {{-- Name English --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.Finance.currencies.fields.name_en') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name[en]" class="form-control form-control-modern"
                                    placeholder="{{ trans('admin.Finance.currencies.fields.name_en') }}" required
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.Finance.currencies.fields.sort_order') }}
                                </label>
                                <input type="number" name="sort_order" class="form-control form-control-modern"
                                    placeholder="0" min="0" max="9999" value="0">
                                <span class="text-danger error-text sort_order_error"></span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-group finance-form-group mb-0">
                                <input type="hidden" name="status" value="0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="add_status" name="status"
                                        class="custom-control-input" value="1" checked>
                                    <label class="custom-control-label" for="add_status">
                                        {{ trans('admin.Finance.currencies.fields.status') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body pt-0 pb-4">
                    <button type="submit" class="btn btn-save-finance">
                        <span class="spinner-border spinner-border-sm d-none mr-1"></span>
                        {{ trans('admin.global.save') }}
                    </button>
                    <button type="button" class="btn btn-cancel-finance" data-dismiss="modal">
                        {{ trans('admin.global.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
