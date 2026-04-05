<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.Academic.academic_years.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <form action="{{ route('admin.Academic.academic_years.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addModal" data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.Academic.academic_years.fields.name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required minlength="2"
                                    maxlength="255" autocomplete="off">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Academic.academic_years.fields.starts_at') }}</label>
                                <input type="date" name="starts_at" class="form-control">
                                <span class="text-danger error-text starts_at_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Academic.academic_years.fields.ends_at') }}</label>
                                <input type="date" name="ends_at" class="form-control">
                                <span class="text-danger error-text ends_at_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.Academic.academic_years.fields.is_current') }} <span
                                        class="text-danger">*</span></label>
                                <select name="is_current" class="form-control" required>
                                    <option value="0">{{ __('admin.Academic.academic_years.not_current') }}</option>
                                    <option value="1">{{ __('admin.Academic.academic_years.current') }}</option>
                                </select>
                                <span class="text-danger error-text is_current_error"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{ __('admin.global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
