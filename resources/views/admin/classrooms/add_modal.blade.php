<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.classrooms.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
    <form action="{{ route('admin.classrooms.store') }}"
          method="POST"
          class="ajax-form"
          data-modal-id="#addModal"
          data-parsley-validate=""    >
        @csrf
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('admin.classrooms.fields.name_ar')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[ar]" id="name_ar" class="form-control" placeholder="{{__('admin.classrooms.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_ar_error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('admin.classrooms.fields.name_en')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[en]" id="name_en" class="form-control" placeholder="{{__('admin.classrooms.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_en_error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ __('admin.classrooms.fields.grade') }} <span class="text-danger">*</span></label>
                        <select name="grade_id" class="form-control select2" required>
                            <option value="" disabled selected>-- {{ __('admin.global.select') }} --</option>
                            @foreach($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text grade_id_error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>{{__('admin.classrooms.fields.sort_order')}}</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0" max="1000">
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('admin.classrooms.fields.status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="1" selected>{{ __('admin.global.active') }}</option>
                            <option value="0">{{ __('admin.global.disabled') }}</option>
                        </select>
                        <span class="text-danger error-text status_error"></span>
                    </div>

                </div>
            </div>
            <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{__('admin.classrooms.fields.notes')}}</label>
                            <textarea class="form-control" name="notes" placeholder="{{__('admin.classrooms.fields.notes')}}" rows="5"></textarea>
                        </div>
                    </div>
                </div>

            <button type="submit" class="btn btn-primary">
                <span class="spinner-border spinner-border-sm d-none"></span> {{__('admin.global.save')}}
            </button>

        </div>

    </form>
</div>
</div>
</div>
