{{-- Assignment Modal --}}
<div class="modal fade assign-modal" id="assign_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assign_modal_title">{{ __('admin.timetables.create_assignment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="assign_form">
                <div class="modal-body">
                    {{-- Subject Selection --}}
                    <div class="form-group">
                        <label class="filter-label">
                            <i class="las la-book"></i> {{ __('admin.global.select') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select select2" id="subject_id" name="subject_id" required>
                            <option value="">{{ __('admin.global.select') }}</option>
                        </select>
                        <small class="form-text text-danger" id="subject_id_error"></small>
                    </div>

                    {{-- Teacher Selection --}}
                    <div class="form-group">
                        <label class="filter-label">
                            <i class="las la-user-tie"></i> {{ __('admin.global.select') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-select select2" id="teacher_id" name="teacher_id" required disabled>
                            <option value="">{{ __('admin.global.select') }}</option>
                        </select>
                        <small class="form-text text-danger" id="teacher_id_error"></small>
                    </div>

                    {{-- Assignment Info --}}
                    <div class="alert alert-info mt-3 d-none" id="assignment_info">
                        <div class="d-flex align-items-center">
                            <i class="las la-info-circle mr-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>{{ __('admin.timetables.assignment_details') }}</strong>
                                <p class="mb-0 mt-1" id="assignment_details"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-dismiss="modal">
                        <i class="las la-times mr-1"></i> {{ __('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-save">
                        <i class="las la-save mr-1"></i> {{ __('admin.global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            'use strict';
            // When modal is shown
            $('#assign_modal').on('shown.bs.modal', function() {
                const sectionId = $(this).data('section_id');
                const slotId = $(this).data('slot_id');
                const subjectId = $(this).data('subject_id');
                const teacherId = $(this).data('teacher_id');

                // Load subjects for this section
                loadSubjectsForSection(sectionId, subjectId);

                // If editing, load teachers
                if (slotId && subjectId) {
                    loadTeachersForSubject(subjectId, teacherId);
                }
            });

            // Subject Change Event
            $('#subject_id').on('change', function() {
                const subjectId = $(this).val();
                $('#teacher_id').prop('disabled', !subjectId).html(
                    '<option value="">{{ __('admin.global.select') }}</option>');

                if (subjectId) {
                    loadTeachersForSubject(subjectId);
                }

                clearError('subject_id');
            });

            // Teacher Change Event
            $('#teacher_id').on('change', function() {
                clearError('teacher_id');
            });

            // Load Subjects for Section
            function loadSubjectsForSection(sectionId, selectedSubjectId = null) {
                if (!sectionId) return;

                $.ajax({
                    url: '{{ route('admin.schedule.timetables.getSubjects') }}',
                    data: {
                        section_id: sectionId
                    },
                    success: function(response) {
                        const $select = $('#subject_id');
                        $select.html('<option value="">{{ __('admin.global.select') }}</option>');

                        $.each(response.data, function(key, subject) {
                            const isSelected = (selectedSubjectId && selectedSubjectId == key) ?
                                'selected' : '';
                            $select.append(
                                `<option value="${key}" ${isSelected}>${subject}</option>`);
                        });

                        $select.prop('disabled', false);
                    }
                });
            }

            // Load Teachers for Subject
            function loadTeachersForSubject(subjectId, selectedTeacherId = null) {
                if (!subjectId) return;

                $.ajax({
                    url: '{{ route('admin.schedule.timetables.getTeachers') }}',
                    data: {
                        subject_id: subjectId
                    },
                    success: function(response) {
                        const $select = $('#teacher_id');
                        $select.html('<option value="">{{ __('admin.global.select') }}</option>');

                        response.data.forEach(teacher => {
                            const isSelected = (selectedTeacherId && selectedTeacherId ==
                                teacher.id) ? 'selected' : '';
                            $select.append(
                                `<option value="${teacher.id}" ${isSelected}>${teacher.name}</option>`
                                );
                        });

                        $select.prop('disabled', false);
                    }
                });
            }

            // Load Slot Data for Editing
            window.loadSlotData = function(slotId) {
                // Relies on data loading passed directly in shown.bs.modal now
            };

            // Form Submit
            $('#assign_form').on('submit', function(e) {
                e.preventDefault();

                const $modal = $('#assign_modal');
                const slotId = $modal.data('slot_id');
                const isEdit = !!slotId;

                const formData = {
                    section_id: $modal.data('section_id'),
                    day_of_week_id: $modal.data('day_id'),
                    class_period_id: $modal.data('period_id'),
                    subject_id: $('#subject_id').val(),
                    teacher_id: $('#teacher_id').val(),
                    academic_year_id: $modal.data('academic_year_id')
                };

                const url = isEdit ?
                    `{{ route('admin.schedule.timetables.index') }}/${slotId}` :
                    '{{ route('admin.schedule.timetables.store') }}';

                const method = isEdit ? 'PUT' : 'POST';

                // Clear previous errors
                clearAllErrors();

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    beforeSend: function() {
                        $('.btn-save').prop('disabled', true).html(
                            '<i class="las la-spinner la-spin mr-1"></i> {{ __('admin.global.saving') }}'
                        );
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.btn-save').prop('disabled', false).html(
                                '<i class="las la-save mr-1"></i> {{ __('admin.global.save') }}'
                            );

                            swal({
                                title: "{{ __('admin.global.success') }}",
                                text: response.message,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });

                            $modal.modal('hide');

                            // Reload the timetable matrix
                            const currentSectionId = $modal.data('section_id');
                            const currentAcademicYearId = $modal.data('academic_year_id');
                            loadTimetableMatrix(currentSectionId, currentAcademicYearId);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            displayErrors(errors);

                            // Show error message
                            swal({
                                title: "{{ __('admin.global.error_title') }}",
                                text: xhr.responseJSON.message ||
                                    "{{ __('admin.timetables.errors.save_failed') }}",
                                type: "error"
                            });
                        } else {
                            swal({
                                title: "{{ __('admin.global.error_title') }}",
                                text: "{{ __('admin.timetables.errors.save_failed') }}",
                                type: "error"
                            });
                        }
                    },
                    complete: function() {
                        $('.btn-save').prop('disabled', false).html(
                            '<i class="las la-save mr-1"></i> {{ __('admin.global.save') }}'
                        );
                    }
                });
            });

            // Display Validation Errors
            function displayErrors(errors) {
                for (const field in errors) {
                    const $errorElement = $(`#${field}_error`);
                    if ($errorElement.length) {
                        $errorElement.text(errors[field][0]);
                        $(`#${field}`).addClass('is-invalid');
                    }
                }
            }

            // Clear All Errors
            function clearAllErrors() {
                $('.form-text.text-danger').text('');
                $('.form-select, .form-control').removeClass('is-invalid');
            }

            // Clear Single Error
            function clearError(fieldId) {
                $(`#${fieldId}_error`).text('');
                $(`#${fieldId}`).removeClass('is-invalid');
            }

            // Reset Modal on Hide
            $('#assign_modal').on('hidden.bs.modal', function() {
                resetAssignForm();
                clearAllErrors();
            });
        });
    </script>
@endpush
