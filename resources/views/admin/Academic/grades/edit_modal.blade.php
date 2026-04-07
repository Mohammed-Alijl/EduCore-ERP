<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.Academic.grades.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
    <form action=""
    method="POST"
          class="ajax-form"
          data-modal-id="#editModal"
          data-parsley-validate="">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group grade-form-group">
                        <label class="grade-form-label">{{__('admin.Academic.grades.fields.name_ar')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[ar]" id="name_ar" class="form-control form-control-modern" placeholder="{{__('admin.Academic.grades.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_ar_error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group grade-form-group">
                        <label class="grade-form-label">{{__('admin.Academic.grades.fields.name_en')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[en]" id="name_en" class="form-control form-control-modern" placeholder="{{__('admin.Academic.grades.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_en_error"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="grade-form-label">{{__('admin.Academic.grades.fields.sort_order')}}</label>
                    <input type="number" name="sort_order" class="form-control form-control-modern" value="0" min="0" max="1000">
                </div>
                <div class="col-md-6">
                    <div class="form-group grade-form-group">
                        <label class="grade-form-label">{{ __('admin.Users.admins.fields.status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-control form-control-modern" required>
                            <option value="1" selected>{{ __('admin.global.active') }}</option>
                            <option value="0">{{ __('admin.global.disabled') }}</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group grade-form-group">
                        <label class="grade-form-label">{{__('admin.Academic.grades.fields.notes')}}</label>
                        <textarea class="form-control form-control-modern" name="notes" placeholder="{{__('admin.Academic.grades.fields.notes')}}" rows="5"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-save-grade">
                <span class="spinner-border spinner-border-sm d-none"></span> {{__('admin.global.save')}}
            </button>
            <button class="btn btn-cancel-grade" data-dismiss="modal" type="button">{{__('admin.global.cancel')}}</button>
        </div>

    </form>
</div>
</div>
</div>
