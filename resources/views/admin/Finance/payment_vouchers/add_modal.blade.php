<div class="modal fade" id="addPaymentVoucherModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentVoucherLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addPaymentVoucherLabel">
                    <i class="las la-hand-holding-usd tx-20 mr-2 ml-1"></i>
                    {{ trans('admin.Finance.payment_vouchers.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ trans('admin.global.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.Finance.payment_vouchers.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addPaymentVoucherModal" data-parsley-validate>
                @csrf

                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.student') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select id="student_id" name="student_id" class="form-control select2-student" required
                                    data-placeholder="{{ trans('admin.global.search') }} {{ trans('admin.Finance.payment_vouchers.fields.student') }}">
                                    <option value=""></option>
                                </select>
                                <span class="text-danger error-text student_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_year_id" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.academic_year') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select id="academic_year_id" name="academic_year_id" class="form-control select2-modal"
                                    required>
                                    <option value="">{{ trans('admin.global.select') }}</option>
                                    @foreach ($lookups['academic_years'] as $academicYear)
                                        <option value="{{ $academicYear->id }}">{{ $academicYear->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text academic_year_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_gateway_id" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.payment_gateway') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select id="payment_gateway_id" name="payment_gateway_id"
                                    class="form-control select2-modal" required>
                                    <option value="">{{ trans('admin.global.select') }}</option>
                                    @foreach ($lookups['payment_gateways'] as $gateway)
                                        <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text payment_gateway_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_number" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.reference_number') }}
                                </label>
                                <input type="text" id="reference_number" name="reference_number" class="form-control"
                                    placeholder="{{ trans('admin.Finance.payment_vouchers.fields.reference_number') }}" />
                                <span class="text-danger error-text reference_number_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.amount') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" min="0.01" id="amount" name="amount"
                                    class="form-control" required />
                                <span class="text-danger error-text amount_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="currency_code" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.currency') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select id="currency_code" name="currency_code" class="form-control select2-modal"
                                    required>
                                    <option value="">{{ trans('admin.global.select') }}</option>
                                    @foreach ($lookups['currencies'] as $currency)
                                        <option value="{{ $currency->code }}" @selected($currency->is_default)>
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text currency_code_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.date') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="{{ now()->toDateString() }}" required />
                                <span class="text-danger error-text date_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description" class="font-weight-bold">
                                    {{ trans('admin.Finance.payment_vouchers.fields.description') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <textarea id="description" name="description" rows="3" class="form-control" required
                                    placeholder="{{ trans('admin.Finance.payment_vouchers.fields.description') }}"></textarea>
                                <span class="text-danger error-text description_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                        <i class="las la-times mr-1"></i>{{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none mr-1"></span>
                        <i class="las la-save mr-1"></i>{{ trans('admin.global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
