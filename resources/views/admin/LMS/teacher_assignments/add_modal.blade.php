<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-plus-circle mr-1 ml-1"></i>
                    {{ trans('admin.LMS.teacher_assignments.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <form action="{{ route('admin.LMS.teacher_assignments.store') }}" method="post" class="ajax-form"
                data-modal-id="#addModal" enctype="multipart/form-data" data-parsley-validate="">
                @csrf
                <div class="modal-body">

                    <h6><i class="las la-user-tie"></i>
                        {{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }} /
                        {{ trans('admin.LMS.teacher_assignments.fields.subject_id') }}</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }} <span
                                        class="text-danger">*</span></label>
                                <select name="teacher_id" class="form-control select2" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['teachers'] as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text teacher_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.subject_id') }} <span
                                        class="text-danger">*</span></label>
                                <select name="subject_id" class="form-control select2" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['subjects'] as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text subject_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <h6><i class="las la-school"></i>
                        {{ trans('admin.LMS.teacher_assignments.fields.section_id') }}</h6>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.grade') }} <span
                                        class="text-danger">*</span></label>
                                <select id="grade_id" class="form-control select2" name="grade_id" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['grades'] as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.classroom') }} <span
                                        class="text-danger">*</span></label>
                                <select id="classroom_id" class="form-control select2" name="classroom_id" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.section_id') }} <span
                                        class="text-danger">*</span></label>
                                <select name="section_id" id="section_id" class="form-control select2" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                </select>
                                <span class="text-danger error-text section_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <h6><i class="las la-calendar"></i>
                        {{ trans('admin.LMS.teacher_assignments.fields.academic_year') }}</h6>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.academic_year') }}
                                    <span class="text-danger">*</span></label>
                                <select name="academic_year" class="form-control select2" required>
                                    <option value="" disabled selected>{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['academic_years'] as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text academic_year_error"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit" id="submit-btn">
                        <span class="spinner-border spinner-border-sm d-none" id="spinner"></span>
                        <span id="btn-text">{{ __('admin.global.save') }}</span>
                    </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal"
                        type="button">{{ __('admin.global.close') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('.select2').select2({
            placeholder: '{{ __('admin.global.select') }}',
            width: '100%',
            dropdownParent: $('#addModal')
        });


        $('select[name="grade_id"]').on('change', function() {

            let gradeId = $(this).val();

            resetDropdown('select[name="classroom_id"]');

            if (!gradeId) return;

            $.ajax({
                url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                type: "GET",
                data: {
                    grade_id: gradeId
                },

                success: function(response) {

                    if (response.success) {

                        $.each(response.data, function(key, classroom) {

                            $('select[name="classroom_id"]').append(
                                `<option value="${key}">${classroom}</option>`
                            );

                        });

                    }

                }
            });

        });


        $('#classroom_id').on('change', function() {
            let classroomId = $(this).val();
            resetDropdown('#section_id');
            if (!classroomId) return;

            $.ajax({
                url: "{{ route('admin.Academic.sections.by-classroom') }}",
                type: "GET",
                data: {
                    classroom_id: classroomId
                },
                success: function(response) {
                    if (response.success) {
                        $.each(response.data, function(key, section) {
                            $('#section_id').append(
                                `<option value="${key}">${section}</option>`);
                        });
                    }
                }
            });
        });

        /* ===============================
        HELPERS
        =============================== */
        function resetDropdown(selector) {

            $(selector).html(`
            <option value="" disabled selected>
                -- {{ trans('admin.global.select') }} --
            </option>
        `);

        }
    </script>
@endpush
