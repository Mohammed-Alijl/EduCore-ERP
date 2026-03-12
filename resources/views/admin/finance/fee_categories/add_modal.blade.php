<div class="modal fade" id="addFeeCategoryModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.finance.fee_categories.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.fee_categories.store') }}"
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#addFeeCategoryModal"
                  data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.finance.fee_categories.fields.title_ar') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title[ar]" class="form-control form-control-modern" placeholder="{{ __('admin.finance.fee_categories.fields.title') }}" required minlength="2" maxlength="255" autocomplete="off">
                                <span class="text-danger error-text title_ar_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.finance.fee_categories.fields.title_en') }} <span class="text-danger">*</span></label>
                                <input type="text" name="title[en]" class="form-control form-control-modern" placeholder="{{ __('admin.finance.fee_categories.fields.title') }}" required minlength="2" maxlength="255" autocomplete="off">
                                <span class="text-danger error-text title_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.finance.fee_categories.fields.description') }}</label>
                                <textarea class="form-control form-control-modern" name="description" placeholder="{{ __('admin.finance.fee_categories.fields.description') }}" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-save-finance">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{ __('admin.global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
