<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ __('admin.Academic.sections.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
    <form action=""
          method="POST"
          class="ajax-form"
          data-modal-id="#editModal"
          data-parsley-validate=""    >
        @csrf
        @method('PUT')
        <div class="modal-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('admin.Academic.sections.fields.name_ar')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[ar]" id="name_ar" class="form-control" placeholder="{{__('admin.Academic.sections.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_ar_error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{__('admin.Academic.sections.fields.name_en')}} <span class="text-danger">*</span></label>
                        <input type="text" name="name[en]" id="name_en" class="form-control" placeholder="{{__('admin.Academic.sections.fields.name')}}" required minlength="3" maxlength="30" autocomplete="off">
                        <span class="text-danger error-text name_en_error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('admin.Academic.sections.fields.grade') }} <span class="text-danger">*</span></label>
                        <select name="grade_id" class="form-control select2" required>
                            <option value="" disabled selected>-- {{ __('admin.global.select') }} --</option>
                            @foreach($grades as $grade)
                                <option value="{{$grade->id}}">{{$grade->name}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text grade_id_error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('admin.Academic.sections.fields.classroom') }} <span class="text-danger">*</span></label>
                        <select name="classroom_id" class="form-control select2" required>
                            <option value="" disabled selected>-- {{ __('admin.global.select') }} --</option>
                        </select>
                        <span class="text-danger error-text grade_id_error"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>{{__('admin.Academic.classrooms.fields.sort_order')}}</label>
                    <input type="number" name="sort_order" class="form-control" value="0" min="0" max="1000">
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('admin.Academic.classrooms.fields.status') }} <span class="text-danger">*</span></label>
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
                            <label>{{__('admin.Academic.classrooms.fields.notes')}}</label>
                            <textarea class="form-control" name="notes" placeholder="{{__('admin.Academic.classrooms.fields.notes')}}" rows="5"></textarea>
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
@push('scripts')
    <script>
        function getClassrooms(gradeId, selectedId = null) {
            var classroomSelect = $('#editModal').find('select[name="classroom_id"]');

            if(gradeId) {
                $.ajax({
                    url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                    type: "GET",
                    data: { grade_id: gradeId },
                    success: function (response) {
                        if (response.success) {
                            classroomSelect.empty();
                            classroomSelect.append('<option value="">{{ __("admin.global.select") }}</option>');

                            $.each(response.data, function (key, classroom) {
                                classroomSelect.append(
                                    `<option value="${key}">${classroom}</option>`
                                );
                            });

                            if (selectedId) {
                                classroomSelect.val(selectedId).trigger('change');
                            }
                        }
                    }
                });
            }
        }

        // Store classroom_id when edit button is clicked BEFORE crud.js triggers change
        var _pendingClassroomId = null;

        $(document).on('click', '.edit-btn', function () {
            _pendingClassroomId = $(this).data('classroom_id') || null;
        });

        // When grade changes (triggered by crud.js), carry the stored classroom_id
        $(document).on('change', '#editModal select[name="grade_id"]', function () {
            var gradeId = $(this).val();
            var selectedId = _pendingClassroomId;
            _pendingClassroomId = null; // reset after first use
            getClassrooms(gradeId, selectedId);
        });
    </script>
@endpush
