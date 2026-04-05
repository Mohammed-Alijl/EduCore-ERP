<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.HR.specializations.edit') }}</h6>
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
                            <div class="form-group">
                                <label>{{__('admin.HR.specializations.fields.name_ar')}} <span class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" id="name_ar" class="form-control" placeholder="{{__('admin.HR.specializations.fields.name_ar')}}" required minlength="2" maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{__('admin.HR.specializations.fields.name_en')}} <span class="text-danger">*</span></label>
                                <input type="text" name="name[en]" id="name_en" class="form-control" placeholder="{{__('admin.HR.specializations.fields.name_en')}}" required minlength="2" maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{__('admin.global.save')}}
                    </button>
                    <button class="btn btn-secondary mt-3" data-dismiss="modal" type="button">{{__('admin.global.cancel')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
