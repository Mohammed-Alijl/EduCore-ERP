<div class="modal fade" id="addStudentDiscountModal" tabindex="-1" role="dialog" aria-labelledby="addStudentDiscountLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- Modal Header --}}
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addStudentDiscountLabel">
                    <i class="las la-percent tx-20 mr-2 ml-1"></i>
                    {{ trans('admin.finance.student_discounts.add') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ trans('admin.global.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- Modal Form --}}
            <form action="{{ route('admin.student_discounts.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addStudentDiscountModal" data-parsley-validate>
                @csrf

                <div class="modal-body p-4">
                    {{-- Row 1: Student & Academic Year --}}
                    <div class="row">
                        {{-- Student Select (AJAX with Select2) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="student_id" class="font-weight-bold">
                                    {{ trans('admin.finance.student_discounts.fields.student') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="student_id" name="student_id" class="form-control select2-student" required
                                    data-placeholder="{{ trans('admin.global.search') }} {{ trans('admin.finance.student_discounts.fields.student') }}">
                                    <option value=""></option>
                                </select>
                                <span class="text-danger error-text student_id_error"></span>
                            </div>
                        </div>

                        {{-- Academic Year Select --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="academic_year_id" class="font-weight-bold">
                                    {{ trans('admin.finance.student_discounts.fields.academic_year') }}
                                    <span class="text-danger">*</span>
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

                    {{-- Row 2: Amount & Date --}}
                    <div class="row">
                        {{-- Amount Input --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="font-weight-bold">
                                    {{ trans('admin.finance.student_discounts.fields.amount') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" step="0.01" min="1" id="amount" name="amount"
                                    class="form-control"
                                    placeholder="{{ trans('admin.finance.student_discounts.fields.amount') }}"
                                    required />
                                <span class="text-danger error-text amount_error"></span>
                            </div>
                        </div>

                        {{-- Date Input --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date" class="font-weight-bold">
                                    {{ trans('admin.finance.student_discounts.fields.date') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="date" name="date" class="form-control"
                                    value="{{ now()->toDateString() }}" required />
                                <span class="text-danger error-text date_error"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Row 3: Description --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="font-weight-bold">
                                    {{ trans('admin.finance.student_discounts.fields.description') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="description" name="description" class="form-control"
                                    placeholder="{{ trans('admin.finance.student_discounts.placeholders.description') }}"
                                    maxlength="255" required />
                                <small class="text-muted">
                                    {{ trans('admin.finance.student_discounts.hints.description') }}
                                </small>
                                <span class="text-danger error-text description_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
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
