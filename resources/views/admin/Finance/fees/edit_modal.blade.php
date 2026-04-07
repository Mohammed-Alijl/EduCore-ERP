<div class="modal fade" id="editFeeModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.Finance.fees.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <form action="" method="POST" class="ajax-form" data-modal-id="#editFeeModal"
                data-parsley-validate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.title_ar') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title[ar]" class="form-control form-control-modern"
                                    placeholder="{{ __('admin.Finance.fees.fields.title') }}" required minlength="2"
                                    maxlength="255" autocomplete="off">
                                <span class="text-danger error-text title_ar_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.title_en') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title[en]" class="form-control form-control-modern"
                                    placeholder="{{ __('admin.Finance.fees.fields.title') }}" required minlength="2"
                                    maxlength="255" autocomplete="off">
                                <span class="text-danger error-text title_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.amount') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control form-control-modern"
                                    step="0.01" min="0" placeholder="0.00" required>
                                <span class="text-danger error-text amount_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.category') }} <span
                                        class="text-danger">*</span></label>
                                <select name="fee_category_id" class="form-control form-control-modern select2"
                                    required>
                                    <option value="">{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['feeCategories'] as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text fee_category_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.academic_year') }}
                                    <span class="text-danger">*</span></label>
                                <select name="academic_year_id" class="form-control form-control-modern select2"
                                    required>
                                    <option value="">{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['academicYears'] as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text academic_year_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group finance-form-group">
                                <label class="finance-form-label">{{ __('admin.Finance.fees.fields.grade') }} <span
                                        class="text-danger">*</span></label>
                                <select name="grade_id" class="form-control form-control-modern select2" required>
                                    <option value="">{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['grades'] as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text grade_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group finance-form-group">
                                <label
                                    class="finance-form-label">{{ __('admin.Finance.fees.fields.classroom') }}</label>
                                <select name="classroom_id" class="form-control form-control-modern select2">
                                    <option value="">{{ __('admin.global.select') }}</option>
                                </select>
                                <span class="text-danger error-text classroom_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group finance-form-group">
                                <label
                                    class="finance-form-label">{{ __('admin.Finance.fees.fields.description') }}</label>
                                <textarea class="form-control form-control-modern" name="description"
                                    placeholder="{{ __('admin.Finance.fees.fields.description') }}" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-save-finance">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{ __('admin.global.save') }}
                    </button>
                    <button class="btn btn-cancel-finance" data-dismiss="modal"
                        type="button">{{ __('admin.global.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
