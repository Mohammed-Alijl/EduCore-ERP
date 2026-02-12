<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.admins.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            <form action="{{ route('admin.admins.store') }}"
                  method="post"
                  class="ajax-form"
                  data-modal-id="#addModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="{{ __('admin.admins.fields.name') }}" required minlength="3" maxlength="30" autocomplete="off">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="{{ __('admin.admins.fields.email') }}" required minlength="3" maxlength="30" autocomplete="off">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password" id="password" class="form-control" required minlength="8" maxlength="30">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.confirm_password') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required data-parsley-equalto="#password">
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="1" selected>{{ __('admin.global.active') }}</option>
                                    <option value="0">{{ __('admin.global.disabled') }}</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.roles') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" required name="roles_name[]" multiple="multiple" style="width: 100%">
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text roles_name_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ __('admin.admins.fields.image') }}</label>
                                <input type="file" class="dropify" data-height="200"  name="image" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg+xml"/>
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit" id="submit-btn">
                        <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                        <span id="btn-text">{{ __('admin.global.save') }}</span>
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('admin.global.close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
