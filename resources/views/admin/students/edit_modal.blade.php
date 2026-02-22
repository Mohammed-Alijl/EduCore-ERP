<!-- edit Student Modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ trans('admin.students.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action=""
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#editModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <!-- Student Information -->
                    <h6 class="mb-3 text-primary"><i class="fas fa-user"></i> {{ trans('admin.students.student_information') }}</h6>
                    <!-- Student Code Preview -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-barcode"></i>
                                <strong>{{ trans('admin.students.fields.student_code') }}:</strong>
                                <span id="student_code_preview">{{$student->student_code}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.name_ar') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" id="name_ar" class="form-control"
                                       placeholder="{{ trans('admin.students.fields.name_ar') }}"
                                       required minlength="3" maxlength="50" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.name_en') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name[en]" id="name_en" class="form-control"
                                       placeholder="{{ trans('admin.students.fields.name_en') }}"
                                       required minlength="3" maxlength="50" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.email') }}</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="student@edu.com" minlength="5" maxlength="50" autocomplete="off">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.password') }} <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password"
                                        minlength="8" maxlength="30">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.password_confirmation') }} <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       data-parsley-equalto="#password">
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Personal Information -->
                    <h6 class="mb-3 text-primary"><i class="fas fa-user"></i> {{ trans('admin.students.personal_information') }}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.national_id') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-only" name="national_id" id="national_id"
                                       maxlength="10" required data-parsley-length="[9, 10]">
                                <span class="text-danger error-text national_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.date_of_birth') }} <span class="text-danger">*</span></label>
                                <input class="form-control" id="editDate" placeholder="DD-MM-YYYY"
                                       type="text" required name="date_of_birth" autocomplete="off">
                                <span class="text-danger error-text date_of_birth_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.gender') }} <span class="text-danger">*</span></label>
                                <select name="gender_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text gender_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.nationality') }} <span class="text-danger">*</span></label>
                                <select name="nationality_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text nationality_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.blood_type') }} <span class="text-danger">*</span></label>
                                <select name="blood_type_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($blood_types as $blood_type)
                                        <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text blood_type_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.religion') }} <span class="text-danger">*</span></label>
                                <select name="religion_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text religion_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <h6 class="mb-3 mt-4 text-primary"><i class="fas fa-graduation-cap"></i> {{ trans('admin.students.academic_information') }}</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.grade') }} <span class="text-danger">*</span></label>
                                <select name="grade_id" id="edit_grade_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text grade_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.classroom') }} <span class="text-danger">*</span></label>
                                <select name="classroom_id" id="edit_classroom_id" class="form-control select2" required>
                                    <option value="{{$student->classroom->id}}" selected>{{$student->classroom->name}}</option>
                                </select>
                                <span class="text-danger error-text classroom_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.section') }} <span class="text-danger">*</span></label>
                                <select name="section_id" id="edit_section_id" class="form-control select2" required>
                                    <option value="{{$student->section->id}}" selected>{{$student->section->name}}</option>
                                </select>
                                <span class="text-danger error-text section_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.academic_year') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="academic_year"
                                       placeholder="2024-2025" required value="{{ date('Y') . '-' . (date('Y') + 1) }}">
                                <span class="text-danger error-text academic_year_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian & Status -->
                    <h6 class="mb-3 mt-4 text-primary"><i class="fas fa-user-shield"></i> {{ trans('admin.students.guardian_info') }}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.guardian') }} <span class="text-danger">*</span></label>
                                <select name="guardian_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach($guardians as $guardian)
                                        <option value="{{ $guardian->id }}">
                                            {{ $guardian->name_father }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text guardian_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="1" selected>{{ trans('admin.global.active') }}</option>
                                    <option value="0">{{ trans('admin.global.disabled') }}</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <h6 class="mb-3 mt-4 text-primary"><i class="fas fa-paperclip"></i> {{ trans('admin.students.fields.attachments') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.image') }}</label>
                                <input type="file" class="form-control" name="image" id="student_image_edit" accept="image/*">
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.students.fields.attachments') }}</label>
                                <input type="file" class="form-control" name="attachments[]" id="student_attachments_edit" multiple>
                                <span class="text-danger error-text attachments_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <i class="fas fa-save"></i> {{ trans('admin.global.save') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> {{ trans('admin.global.cancel') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


@push('scripts')
    <script>

        $(function () {
            let isInitialLoad = true;

            /* ===============================
            FILE INPUT INITIALIZATION
            =============================== */
            function initFileInputs(imagePreviewUrl = [], attachmentsPreviewUrls = [], attachmentsConfig = []) {
                $('#student_image_edit').fileinput('destroy');
                $('#student_attachments_edit').fileinput('destroy');

                $('#student_image_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false,
                    showRemove: true,
                    overwriteInitial: true,
                    initialPreviewAsData: true,
                    initialPreview: imagePreviewUrl,
                    allowedFileExtensions: ['jpg','jpeg','png','svg'],
                    maxFileSize: 2048,
                    browseOnZoneClick: true,
                });

                $('#student_attachments_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false,
                    showCaption: true,
                    overwriteInitial: false,
                    initialPreviewAsData: true,
                    initialPreview: attachmentsPreviewUrls,
                    initialPreviewConfig: attachmentsConfig,
                    allowedFileExtensions: ['pdf','doc','docx', 'jpg','jpeg','png','svg','zip'],
                    maxFileSize: 5120,
                    maxFileCount: 5,
                    browseOnZoneClick: true,
                });
            }

            /* ===============================
            WHEN MODAL OPENS
            =============================== */
            $('#editModal').on('show.bs.modal', function (event) {
                isInitialLoad = true;

                let button = $(event.relatedTarget);

                let imageUrl = button.data('image');
                let imageArray = imageUrl ? [imageUrl] : [];
                let attachments = button.data('attachments') || [];
                let configs = button.data('configs') || [];

                initFileInputs(imageArray, attachments, configs);

                let gradeId = button.data('grade_id');
                let classroomId = button.data('classroom_id');
                let sectionId = button.data('section_id');

                $('#edit_grade_id').val(gradeId).trigger('change');

            });

            /* ===============================
            CASCADING DROPDOWNS
            =============================== */
            $('#edit_grade_id').on('change', function () {
                let gradeId = $(this).val();

                if (!isInitialLoad) {
                    resetDropdown('#edit_classroom_id');
                    resetDropdown('#edit_section_id');
                }

                if (!gradeId) return;

                $.ajax({
                    url: "{{ route('admin.classrooms.by-grade') }}",
                    type: "GET",
                    data: { grade_id: gradeId },
                    success: function (response) {
                        if (response.success) {
                            $.each(response.data, function (key, classroom) {
                                $('#edit_classroom_id').append(`<option value="${key}">${classroom}</option>`);
                            });

                            isInitialLoad = false;
                        }
                    }
                });
            });

            $('#edit_classroom_id').on('change', function () {
                let classroomId = $(this).val();
                if (!isInitialLoad) {
                    resetDropdown('#edit_section_id');
                }
                if (!classroomId) return;

                $.ajax({
                    url: "{{ route('admin.sections.by-classroom') }}",
                    type: "GET",
                    data: { classroom_id: classroomId },
                    success: function (response) {
                        if (response.success) {
                            $.each(response.data, function (key, section) {
                                $('#edit_section_id').append(`<option value="${key}">${section}</option>`);
                            });
                        }
                    }
                });
            });

            /* ===============================
            HELPERS
            =============================== */
            function resetDropdown(selector) {
                $(selector).html(`<option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>`);
            }

            $('#editModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
                $('.error-text').text('');
                isInitialLoad = true;
            });

            /* Date Mask */
            $('#editDate').mask('99-99-9999');
        });

    </script>

@endpush
