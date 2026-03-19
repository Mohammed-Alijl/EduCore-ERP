<div class="modal fade" id="editPaymentGatewayModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-cog mr-2"></i>
                    {{ trans('admin.finance.payment_gateways.edit') }}
                    <span class="badge badge-light ml-2 gateway-code-display"
                        style="font-size: 0.75rem; letter-spacing: 1px;"></span>
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST" class="ajax-form" data-modal-id="#editPaymentGatewayModal"
                data-parsley-validate="">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        {{-- Name Arabic --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.finance.payment_gateways.fields.name_ar') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name[ar]" class="form-control form-control-modern"
                                    placeholder="{{ trans('admin.finance.payment_gateways.fields.name_ar') }}" required
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        {{-- Name English --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.finance.payment_gateways.fields.name_en') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name[en]" class="form-control form-control-modern"
                                    placeholder="{{ trans('admin.finance.payment_gateways.fields.name_en') }}" required
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Surcharge Percentage --}}
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">
                                    {{ trans('admin.finance.payment_gateways.fields.surcharge_percentage') }}
                                </label>
                                <input type="number" name="surcharge_percentage"
                                    class="form-control form-control-modern" placeholder="0.00" step="0.01"
                                    min="0" max="99.99">
                                <span class="text-danger error-text surcharge_percentage_error"></span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-group finance-form-group mb-0">
                                <input type="hidden" name="status" value="0">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="edit_status" name="status" class="custom-control-input"
                                        value="1">
                                    <label class="custom-control-label" for="edit_status">
                                        {{ trans('admin.finance.payment_gateways.fields.status') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dynamic Settings Section --}}
                    <div id="edit_settings_container" class="d-none mt-3">
                        <hr>
                        <h6 class="font-weight-bold mb-3">
                            <i class="las la-cog mr-1"></i>
                            {{ trans('admin.finance.payment_gateways.fields.settings') }}
                        </h6>
                        <div id="edit_settings_fields" class="row">
                            {{-- Dynamically populated by JavaScript --}}
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
