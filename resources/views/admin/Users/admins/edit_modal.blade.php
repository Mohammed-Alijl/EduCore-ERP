<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-pen mr-1 ml-1"></i> {{ __('admin.Users.admins.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>

            <form action=""
                  method="post"
                  class="ajax-form"
                  data-modal-id="#editModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="id">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control form-control-modern" required minlength="3" maxlength="30">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.email') }} <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control form-control-modern" required>
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.password') }} ({{ __('admin.global.optional') }})</label>
                                <input type="password" name="password" id="edit_password" class="form-control form-control-modern" minlength="8">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control form-control-modern" data-parsley-equalto="#edit_password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.status') }} <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control form-control-modern" required>
                                    <option value="1">{{ __('admin.global.active') }}</option>
                                    <option value="0">{{ __('admin.global.disabled') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.Users.admins.fields.roles') }} <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="roles" required name="roles_name[]" multiple="multiple" style="width: 100%">
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
                                <label>{{ __('admin.Users.admins.fields.image') }}</label>
                                <input type="file" class="dropify" data-height="200" name="image" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg+xml"/>
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit" id="update-btn">
                        <span class="spinner-border spinner-border-sm d-none" id="update-spinner"></span>
                        <span id="update-btn-text">{{ __('admin.global.save_changes') }}</span>
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('admin.global.close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
