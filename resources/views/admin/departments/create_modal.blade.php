<!-- Create Department Modal -->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-plus-circle mr-1 ml-1"></i>
                    {{ __('admin.departments.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.departments.store') }}"
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#createModal"
                  data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.departments.fields.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control"
                                       placeholder="{{ __('admin.departments.fields.name') }}"
                                       required minlength="2" maxlength="255" autocomplete="off">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.departments.fields.description') }}</label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                          placeholder="{{ __('admin.departments.fields.description') }}"
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
