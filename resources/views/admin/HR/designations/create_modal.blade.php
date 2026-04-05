<!-- Create Designation Modal -->
<div class="modal fade" id="createDesignationModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-plus-circle mr-1 ml-1"></i>
                    {{ __('admin.HR.designations.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.HR.designations.store') }}"
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#createDesignationModal"
                  data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.HR.designations.fields.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="{{ __('admin.HR.designations.fields.name') }}"
                                       required minlength="2" maxlength="255" autocomplete="off">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.HR.designations.fields.department') }} <span class="text-danger">*</span></label>
                                <select name="department_id" id="department_id" class="form-control" required>
                                    <option value="">{{ __('admin.HR.designations.select_department') }}</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text department_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.HR.designations.fields.default_salary') }}</label>
                                <input type="number" name="default_salary" id="default_salary" class="form-control"
                                       placeholder="{{ __('admin.HR.designations.fields.default_salary') }}"
                                       step="0.01" min="0" autocomplete="off">
                                <span class="text-danger error-text default_salary_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.HR.designations.fields.can_teach') }} <span class="text-danger">*</span></label>
                                <select name="can_teach" id="can_teach" class="form-control" required>
                                    <option value="0">{{ __('admin.global.no') }}</option>
                                    <option value="1">{{ __('admin.global.yes') }}</option>
                                </select>
                                <span class="text-danger error-text can_teach_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.HR.designations.fields.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                          placeholder="{{ __('admin.HR.designations.fields.description') }}"
                                          maxlength="500"></textarea>
                                <span class="text-danger error-text description_error"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{ __('admin.global.save') }}
                    </button>
                    <button class="btn btn-secondary mt-3" data-dismiss="modal" type="button">{{ __('admin.global.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
