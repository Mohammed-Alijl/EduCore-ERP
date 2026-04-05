<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fas fa-pen mr-1 ml-1"></i>
                    {{ trans('admin.global.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                        aria-hidden="true">&times;</span></button>
            </div>

            <form action="" method="post" class="ajax-form" data-modal-id="#editModal"
                enctype="multipart/form-data" data-parsley-validate="">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="id">

                <div class="modal-body">

                    <h6><i class="las la-user-tie"></i>
                        {{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }} /
                        {{ trans('admin.LMS.teacher_assignments.fields.subject_id') }}</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.LMS.teacher_assignments.fields.teacher_id') }} <span
                                        class="text-danger">*</span></label>
                                <select name="teacher_id" id="edit_teacher_id" class="form-control select2-edit"
                                    required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
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
                                <select name="subject_id" id="edit_subject_id" class="form-control select2-edit"
                                    required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
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
                                <label>{{ trans('admin.Academic.grades.title') }} <span class="text-danger">*</span></label>
                                <select id="edit_grade_id" class="form-control select2-edit" required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
                                    @foreach ($lookups['grades'] as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.Academic.classrooms.title') }} <span class="text-danger">*</span></label>
                                <select id="edit_classroom_id" name="classroom_id" class="form-control select2-edit"
                                    required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.Academic.sections.title') }} <span class="text-danger">*</span></label>
                                <select name="section_id" id="edit_section_id" class="form-control select2-edit"
                                    required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
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
                                <select name="academic_year" id="edit_academic_year" class="form-control select2-edit"
                                    required>
                                    <option value="" disabled>{{ __('admin.global.select') }}</option>
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
                    <button class="btn ripple btn-primary" type="submit" id="update-btn">
                        <span class="spinner-border spinner-border-sm d-none" id="update-spinner"></span>
                        <span id="update-btn-text">{{ __('admin.global.save_changes') }}</span>
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
        $(document).ready(function() {
            $('.select2-edit').select2({
                placeholder: '{{ __('admin.global.select') }}',
                width: '100%',
                dropdownParent: $('#editModal')
            });

            let isInitialLoad = true;
            let _pendingClassroomId = null;
            let _pendingSectionId = null;

            /* ═══════════════════════════════════════
               HELPERS
            ═══════════════════════════════════════ */
            function resetEditDropdown(selector) {
                $(selector).html(
                    '<option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>'
                );
            }

            /* ═══════════════════════════════════════
               EDIT BUTTON CLICK — Populate Modal
            ═══════════════════════════════════════ */
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                isInitialLoad = true;

                const editUrl = $(this).data('edit-url');
                const updateUrl = $(this).data('update-url');

                $.ajax({
                    url: editUrl,
                    type: 'GET',
                    success: function(response) {
                        $('#id').val(response.id);
                        $('#edit_teacher_id').val(response.teacher_id).trigger('change');
                        $('#edit_subject_id').val(response.subject_id).trigger('change');
                        $('#edit_academic_year').val(response.academic_year).trigger('change');

                        // Store pending IDs for the cascading chain
                        _pendingClassroomId = response.classroom_id;
                        _pendingSectionId = response.section_id;

                        // Pre-fill dropdowns immediately with the known values
                        $('#edit_classroom_id').html(
                            `<option value="${response.classroom_id}" selected>${response.classroom_name}</option>`
                        );
                        $('#edit_section_id').html(
                            `<option value="${response.section_id}" selected>${response.section_name}</option>`
                        );

                        // Trigger grade change → cascading AJAX loads classrooms → sections
                        $('#edit_grade_id').val(response.grade_id).trigger('change');

                        // Set form action to the update URL
                        $('#editModal form').attr('action', updateUrl);
                        $('#editModal').modal('show');
                    },
                    error: function() {
                        console.error('Error fetching assignment data for edit modal');
                    }
                });
            });

            /* ═══════════════════════════════════════
               CASCADING DROPDOWNS
            ═══════════════════════════════════════ */
            $('#edit_grade_id').on('change', function() {
                let gradeId = $(this).val();

                if (!isInitialLoad) {
                    _pendingClassroomId = null;
                    _pendingSectionId = null;
                    resetEditDropdown('#edit_classroom_id');
                    resetEditDropdown('#edit_section_id');
                }

                if (!gradeId) return;

                $.ajax({
                    url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                    type: 'GET',
                    data: {
                        grade_id: gradeId
                    },
                    success: function(response) {
                        if (response.success) {
                            if (isInitialLoad && _pendingClassroomId) {
                                $('#edit_classroom_id').empty();
                            }
                            $.each(response.data, function(key, classroom) {
                                $('#edit_classroom_id').append(
                                    `<option value="${key}">${classroom}</option>`
                                );
                            });
                            if (_pendingClassroomId) {
                                $('#edit_classroom_id').val(_pendingClassroomId).trigger(
                                    'change');
                            }
                            isInitialLoad = false;
                        }
                    }
                });
            });

            $('#edit_classroom_id').on('change', function() {
                let classroomId = $(this).val();

                if (!isInitialLoad) {
                    _pendingSectionId = null;
                    resetEditDropdown('#edit_section_id');
                }

                if (!classroomId) return;

                $.ajax({
                    url: "{{ route('admin.Academic.sections.by-classroom') }}",
                    type: 'GET',
                    data: {
                        classroom_id: classroomId
                    },
                    success: function(response) {
                        if (response.success) {
                            if (_pendingSectionId) {
                                $('#edit_section_id').empty();
                            }
                            $.each(response.data, function(key, section) {
                                $('#edit_section_id').append(
                                    `<option value="${key}">${section}</option>`
                                );
                            });
                            if (_pendingSectionId) {
                                $('#edit_section_id').val(_pendingSectionId).trigger('change');
                                _pendingSectionId = null;
                            }
                        }
                    }
                });
            });

            /* Reset on close */
            $('#editModal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
                $('.error-text').text('');
                isInitialLoad = true;
                resetEditDropdown('#edit_classroom_id');
                resetEditDropdown('#edit_section_id');
            });
        });
    </script>
@endpush
