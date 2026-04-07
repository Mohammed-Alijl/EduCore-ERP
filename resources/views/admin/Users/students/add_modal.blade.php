
<!-- ══════════════════════════════════════════
     ADD STUDENT MODAL
══════════════════════════════════════════ -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            {{-- ─── HEADER ─── --}}
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-user-graduate mr-2 ml-1 tx-18"></i>
                    {{ trans('admin.Users.students.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.Users.students.store') }}"
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#addModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf

                {{-- ─── NAV TABS ─── --}}
                <ul class="nav nav-tabs-modal" id="addStudentTabs" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="tab-personal-tab" data-toggle="tab"
                           href="#tab-personal" role="tab">
                            <span class="tab-icon"><i class="las la-user"></i></span>
                            {{ trans('admin.Users.students.student_information') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-academic-tab" data-toggle="tab"
                           href="#tab-academic" role="tab">
                            <span class="tab-icon"><i class="las la-graduation-cap"></i></span>
                            {{ trans('admin.Users.students.academic_information') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-guardian-tab" data-toggle="tab"
                           href="#tab-guardian" role="tab">
                            <span class="tab-icon"><i class="las la-user-shield"></i></span>
                            {{ trans('admin.Users.students.guardian_info') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-attachments-tab" data-toggle="tab"
                           href="#tab-attachments" role="tab">
                            <span class="tab-icon"><i class="las la-paperclip"></i></span>
                            {{ trans('admin.Users.students.fields.attachments') }}
                        </a>
                    </li>

                </ul>

                {{-- ─── TAB CONTENT ─── --}}
                <div class="tab-content" id="addStudentTabContent">

                    {{-- ═══════════════════════════════════════
                         TAB 1 — Personal Details
                    ═══════════════════════════════════════ --}}
                    <div class="tab-pane fade show active" id="tab-personal" role="tabpanel">

                        {{-- Student Code Banner --}}
                        <div class="student-code-banner">
                            <i class="las la-id-card-alt"></i>
                            <div>
                                <div>
                                    <strong>{{ trans('admin.Users.students.fields.student_code') }}:</strong>
                                    <span id="student_code_preview" class="code-value ml-1 mr-1"></span>
                                </div>
                                <small>{{ trans('admin.Users.students.student_code_help') }}</small>
                            </div>
                        </div>

                        {{-- Section: Name --}}
                        <div class="section-label">
                            <i class="las la-font"></i>
                            {{ trans('admin.Users.students.fields.name') }}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.name_ar') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-language"></i></span>
                                        </div>
                                        <input type="text" name="name[ar]" id="name_ar"
                                               class="form-control form-control-modern"
                                               placeholder="{{ trans('admin.Users.students.fields.name_ar') }}"
                                               required minlength="3" maxlength="50" autocomplete="off">
                                    </div>
                                    <span class="text-danger error-text name_ar_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.name_en') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-language"></i></span>
                                        </div>
                                        <input type="text" name="name[en]" id="name_en"
                                               class="form-control form-control-modern"
                                               placeholder="{{ trans('admin.Users.students.fields.name_en') }}"
                                               required minlength="3" maxlength="50" autocomplete="off">
                                    </div>
                                    <span class="text-danger error-text name_en_error d-block"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Account --}}
                        <div class="section-label mt-2">
                            <i class="las la-lock"></i>
                            {{ trans('admin.Users.students.fields.email') }} & {{ trans('admin.Users.students.fields.password') }}
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('admin.Users.students.fields.email') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-envelope"></i></span>
                                        </div>
                                        <input type="email" name="email" id="email"
                                               class="form-control form-control-modern"
                                               placeholder="student@edu.com"
                                               minlength="5" maxlength="50" autocomplete="off">
                                    </div>
                                    <span class="text-danger error-text email_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.password') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-key"></i></span>
                                        </div>
                                        <input type="password" name="password" id="password"
                                               class="form-control form-control-modern"
                                               required minlength="8" maxlength="30">
                                    </div>
                                    <span class="text-danger error-text password_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.password_confirmation') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-check-circle"></i></span>
                                        </div>
                                        <input type="password" name="password_confirmation"
                                               class="form-control form-control-modern"
                                               required data-parsley-equalto="#password">
                                    </div>
                                    <span class="text-danger error-text password_confirmation_error d-block"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Personal --}}
                        <div class="section-label mt-2">
                            <i class="las la-id-card"></i>
                            {{ trans('admin.Users.students.personal_information') }}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.national_id') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-fingerprint"></i></span>
                                        </div>
                                        <input type="text" name="national_id" id="national_id"
                                               class="form-control form-control-modern numeric-only"
                                               maxlength="10" required data-parsley-length="[9, 10]">
                                    </div>
                                    <span class="text-danger error-text national_id_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.date_of_birth') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-calendar"></i></span>
                                        </div>
                                        <input class="form-control form-control-modern" id="dateMask"
                                               placeholder="DD-MM-YYYY" type="text" required name="date_of_birth">
                                    </div>
                                    <span class="text-danger error-text date_of_birth_error d-block"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.gender') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="gender_id" class="form-control form-control-modern select2" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($genders as $gender)
                                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text gender_id_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.nationality') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="nationality_id" class="form-control form-control-modern select2" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($nationalities as $nationality)
                                            <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text nationality_id_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.blood_type') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="blood_type_id" class="form-control form-control-modern select2" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($blood_types as $blood_type)
                                            <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text blood_type_id_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.religion') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="religion_id" class="form-control form-control-modern select2" required>
                                        <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        @foreach($religions as $religion)
                                            <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text religion_id_error d-block"></span>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /tab-personal --}}

                    {{-- ═══════════════════════════════════════
                         TAB 2 — Academic Info
                    ═══════════════════════════════════════ --}}
                    <div class="tab-pane fade" id="tab-academic" role="tabpanel">

                        <div class="section-label">
                            <i class="las la-graduation-cap"></i>
                            {{ trans('admin.Users.students.academic_information') }}
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.academic_year') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-calendar-alt"></i></span>
                                        </div>
                                        <select name="academic_year" class="form-control form-control-modern select2" required>
                                            <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                            @php $defaultYear = date('Y') . '-' . (date('Y') + 1); @endphp
                                            @foreach($academicYears as $year)
                                                <option value="{{ $year->name }}"
                                                    {{ old('academic_year', $defaultYear) == $year->name ? 'selected' : '' }}>
                                                    {{ $year->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger error-text academic_year_error d-block"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.grade') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-layer-group"></i></span>
                                        </div>
                                        <select name="grade_id" id="grade_id"
                                                class="form-control form-control-modern select2" required>
                                            <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                            @foreach($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger error-text grade_id_error d-block"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.classroom') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-chalkboard"></i></span>
                                        </div>
                                        <select name="classroom_id" id="classroom_id"
                                                class="form-control form-control-modern select2" required>
                                            <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        </select>
                                    </div>
                                    <span class="text-danger error-text classroom_id_error d-block"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.section') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-users"></i></span>
                                        </div>
                                        <select name="section_id" id="section_id"
                                                class="form-control form-control-modern select2" required>
                                            <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                        </select>
                                    </div>
                                    <span class="text-danger error-text section_id_error d-block"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Helpful academic note --}}
                        <div class="alert alert-light mt-3 border rounded-lg p-3" style="font-size:0.82rem;">
                            <i class="las la-info-circle text-primary mr-1 ml-1 tx-16"></i>
                            {{ trans('admin.Users.students.academic_note') }}
                        </div>

                    </div>{{-- /tab-academic --}}

                    {{-- ═══════════════════════════════════════
                         TAB 3 — Guardian & Status
                    ═══════════════════════════════════════ --}}
                    <div class="tab-pane fade" id="tab-guardian" role="tabpanel">

                        <div class="section-label">
                            <i class="las la-user-shield"></i>
                            {{ trans('admin.Users.students.guardian_info') }}
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.guardian') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-user-friends"></i></span>
                                        </div>
                                        <select name="guardian_id" class="form-control form-control-modern select2" required>
                                            <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                            @foreach($guardians as $guardian)
                                                <option value="{{ $guardian->id }}">{{ $guardian->name_father }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span class="text-danger error-text guardian_id_error d-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('admin.Users.students.fields.status') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="las la-toggle-on"></i></span>
                                        </div>
                                        <select name="status" class="form-control form-control-modern" required>
                                            <option value="1" selected>{{ trans('admin.global.active') }}</option>
                                            <option value="0">{{ trans('admin.global.disabled') }}</option>
                                        </select>
                                    </div>
                                    <span class="text-danger error-text status_error d-block"></span>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /tab-guardian --}}

                    {{-- ═══════════════════════════════════════
                         TAB 4 — Attachments
                    ═══════════════════════════════════════ --}}
                    <div class="tab-pane fade" id="tab-attachments" role="tabpanel">

                        <div class="section-label">
                            <i class="las la-image"></i>
                            {{ trans('admin.Users.students.fields.image') }}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('admin.Users.students.fields.image') }}</label>
                                    <input type="file" class="form-control" name="image"
                                           id="student_image" accept="image/*">
                                    <span class="text-danger error-text image_error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="section-label mt-3">
                            <i class="las la-file-alt"></i>
                            {{ trans('admin.Users.students.fields.attachments') }}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('admin.Users.students.fields.attachments') }}</label>
                                    <input type="file" class="form-control" name="attachments[]"
                                           id="student_attachments" multiple>
                                    <span class="text-danger error-text attachments_error"></span>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /tab-attachments --}}

                </div>{{-- /tab-content --}}

                {{-- ─── Dot Indicators ─── --}}
                <div class="tab-steps-indicator px-3 pb-1" id="tabIndicator">
                    <span class="active" data-tab="tab-personal"></span>
                    <span data-tab="tab-academic"></span>
                    <span data-tab="tab-guardian"></span>
                    <span data-tab="tab-attachments"></span>
                </div>

                {{-- ─── FOOTER ─── --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel-student" data-dismiss="modal">
                        <i class="las la-times mr-1 ml-1"></i>
                        {{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-save-student">
                        <span class="spinner-border spinner-border-sm d-none mr-1 ml-1"></span>
                        <i class="las la-save mr-1 ml-1"></i>
                        {{ trans('admin.global.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')

    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/themes/fa5/theme.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/locales/ar.js"></script>

    <script>

        $(function () {

            /* ─── Dot Indicator Sync ─── */
            $('#addStudentTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                let activeTabId = $(e.target).attr('href').replace('#', '');
                $('#tabIndicator span').removeClass('active');
                $('#tabIndicator span[data-tab="' + activeTabId + '"]').addClass('active');
            });

            /* ═══════════════════════════════════════
               FILE INPUT INITIALIZATION
            ═══════════════════════════════════════ */

            function initFileInputs() {

                if (!$('#student_image').data('fileinput')) {
                    $('#student_image').fileinput({
                        theme: 'fa5',
                        language: '{{ app()->getLocale() }}',
                        uploadUrl: '#',
                        showUpload: false,
                        showCancel: false,
                        showRemove: true,
                        showClose: false,
                        browseOnZoneClick: true,
                        fileActionSettings: {
                            showUpload: false,
                            showRemove: true,
                            showZoom: true,
                            showDrag: true,
                            showRotate: true
                        },
                        layoutTemplates: { actionUpload: '' },
                        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'svg'],
                        maxFileSize: 2048,
                        maxFileCount: 1,
                        overwriteInitial: false,
                        initialPreviewAsData: true
                    });
                }

                if (!$('#student_attachments').data('fileinput')) {
                    $('#student_attachments').fileinput({
                        theme: 'fa5',
                        language: '{{ app()->getLocale() }}',
                        uploadUrl: '#',
                        showUpload: false,
                        showCaption: true,
                        showCancel: false,
                        showClose: false,
                        browseOnZoneClick: true,
                        overwriteInitial: false,
                        initialPreviewAsData: true,
                        allowedFileExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'svg', 'zip'],
                        maxFileSize: 5120,
                        maxFileCount: 5,
                        fileActionSettings: {
                            showUpload: false,
                            showRemove: true,
                            showRotate: true,
                            showZoom: true,
                            showDrag: false
                        }
                    });
                }
            }

            /* ═══════════════════════════════════════
               WHEN MODAL OPENS
            ═══════════════════════════════════════ */

            $('#addModal').on('shown.bs.modal', function () {
                initFileInputs();
                loadStudentCode();
                // Reset to first tab
                $('#addStudentTabs a[href="#tab-personal"]').tab('show');
            });

            /* ═══════════════════════════════════════
               RESET WHEN MODAL CLOSES
            ═══════════════════════════════════════ */

            $('#addModal').on('hidden.bs.modal', function () {
                let form = $(this).find('form');
                form.trigger('reset');
                $('.error-text').text('');
                resetDropdown('#classroom_id');
                resetDropdown('#section_id');
                clearFileInputs();
                // Reset tab indicator
                $('#tabIndicator span').removeClass('active');
                $('#tabIndicator span[data-tab="tab-personal"]').addClass('active');
            });

            /* ═══════════════════════════════════════
               LOAD STUDENT CODE
            ═══════════════════════════════════════ */

            function loadStudentCode() {
                $.ajax({
                    url: "{{ route('admin.Users.students.next-code') }}",
                    type: "GET",
                    success: function (response) {
                        if (response.status) {
                            $('#student_code_preview').text(response.student_code);
                        }
                    }
                });
            }

            /* ═══════════════════════════════════════
               CASCADING DROPDOWNS
            ═══════════════════════════════════════ */

            $('#grade_id').on('change', function () {
                let gradeId = $(this).val();
                resetDropdown('#classroom_id');
                resetDropdown('#section_id');
                if (!gradeId) return;

                $.ajax({
                    url: "{{ route('admin.Academic.classrooms.by-grade') }}",
                    type: "GET",
                    data: { grade_id: gradeId },
                    success: function (response) {
                        if (response.success) {
                            $.each(response.data, function (key, classroom) {
                                $('#classroom_id').append(`<option value="${key}">${classroom}</option>`);
                            });
                        }
                    }
                });
            });

            $('#classroom_id').on('change', function () {
                let classroomId = $(this).val();
                resetDropdown('#section_id');
                if (!classroomId) return;

                $.ajax({
                    url: "{{ route('admin.Academic.sections.by-classroom') }}",
                    type: "GET",
                    data: { classroom_id: classroomId },
                    success: function (response) {
                        if (response.success) {
                            $.each(response.data, function (key, section) {
                                $('#section_id').append(`<option value="${key}">${section}</option>`);
                            });
                        }
                    }
                });
            });

            /* ═══════════════════════════════════════
               HELPERS
            ═══════════════════════════════════════ */

            function resetDropdown(selector) {
                $(selector).html(`<option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>`);
            }

            function clearFileInputs() {
                if ($('#student_image').data('fileinput'))      $('#student_image').fileinput('clear');
                if ($('#student_attachments').data('fileinput')) $('#student_attachments').fileinput('clear');
            }

            /* Numeric only */
            $(document).on('input', '.numeric-only', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            /* Date Mask */
            $('#dateMask').mask('99-99-9999');

        });

    </script>

@endpush
