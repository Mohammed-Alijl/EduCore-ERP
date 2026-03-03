<style>
    /* ══════════════════════════════════════════
       EDIT STUDENT MODAL — CUSTOM STYLES
       (mirrors add_modal design exactly)
    ══════════════════════════════════════════ */

    #editModal .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    #editModal .modal-header {
        background: linear-gradient(135deg, #0ea573 0%, #057a52 100%);
        padding: 1.25rem 1.75rem;
        border-bottom: none;
    }
    #editModal .modal-header .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 0.3px;
    }
    #editModal .modal-header .close {
        color: rgba(255, 255, 255, 0.8);
        opacity: 1;
        text-shadow: none;
        font-size: 1.4rem;
    }
    #editModal .modal-header .close:hover { color: #fff; }

    /* ─── Tabs ─── */
    .nav-tabs-edit-student {
        border-bottom: 2px solid #e8ecf4;
        padding: 0 1rem;
        background: #f8f9fc;
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .nav-tabs-edit-student .nav-item { white-space: nowrap; }
    .nav-tabs-edit-student .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        border-radius: 0;
        color: #6c7a9c;
        font-weight: 600;
        font-size: 0.835rem;
        padding: 0.85rem 1.1rem;
        letter-spacing: 0.2px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .nav-tabs-edit-student .nav-link:hover { color: #0ea573; background: transparent; }
    .nav-tabs-edit-student .nav-link.active {
        color: #0ea573;
        border-bottom-color: #0ea573;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-edit-student .nav-link .tab-icon {
        width: 26px; height: 26px;
        border-radius: 7px;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        transition: background 0.2s;
    }
    .nav-tabs-edit-student .nav-link.active .tab-icon {
        background: rgba(14, 165, 115, 0.12);
        color: #0ea573;
    }
    .nav-tabs-edit-student .nav-link:not(.active) .tab-icon {
        background: rgba(0,0,0,0.04);
        color: #6c7a9c;
    }

    /* ─── Student Code Banner (Edit variant — teal) ─── */
    #editModal .student-code-banner {
        background: linear-gradient(135deg, rgba(14,165,115,0.07) 0%, rgba(5,122,82,0.05) 100%);
        border: 1px dashed rgba(14, 165, 115, 0.35);
        border-radius: 10px;
        padding: 0.75rem 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    #editModal .student-code-banner i { color: #0ea573; font-size: 1.1rem; }
    #editModal .student-code-banner .code-value {
        font-size: 1.1rem; font-weight: 700;
        color: #0ea573; letter-spacing: 1px;
    }
    #editModal .student-code-banner small { font-size: 0.75rem; color: #94a3b8; }

    /* ─── Section Labels ─── */
    #editModal .section-label {
        font-size: 0.7rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.2px;
        color: #94a3b8; margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f2f8;
        display: flex; align-items: center; gap: 0.5rem;
    }
    #editModal .section-label i { color: #0ea573; font-size: 0.95rem; }

    /* ─── Loader ─── */
    #edit_modal_loader .spinner-border { color: #0ea573; width: 2.5rem; height: 2.5rem; }
    #edit_modal_loader p { color: #6c7a9c; font-size: 0.9rem; margin-top: 0.75rem; }

    /* ─── Form Controls ─── */
    #editModal .form-group {
        display: flex;
        flex-direction: column;
    }
    #editModal .error-text {
        display: block !important;
        width: 100%;
        margin-top: 0.3rem;
        font-size: 0.78rem;
        min-height: 0.9rem;
        order: 99;
    }
    #editModal .form-control-modern {
        border-radius: 8px;
        border: 1.5px solid #e3e6f0;
        padding: 0.55rem 0.9rem;
        font-size: 0.875rem;
        box-shadow: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        height: auto;
    }
    #editModal .form-control-modern:focus {
        border-color: #0ea573;
        box-shadow: 0 0 0 0.2rem rgba(14, 165, 115, 0.15);
    }
    #editModal .input-group-text {
        background: #f0fbf7;
        border: 1.5px solid #e3e6f0;
        border-radius: 8px 0 0 8px;
        color: #0ea573;
        font-size: 0.9rem;
    }
    [dir="rtl"] #editModal .input-group-text { border-radius: 0 8px 8px 0; }

    #editModal .form-label {
        font-size: 0.815rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.35rem;
    }

    /* ─── Tab Pane ─── */
    #editModal .tab-content {
        padding: 1.5rem 1.75rem;
        min-height: 340px;
    }

    /* ─── Tab Dot Indicators ─── */
    .tab-steps-indicator-edit {
        display: flex; justify-content: center; gap: 0.35rem;
        padding: 0.5rem 0 0;
    }
    .tab-steps-indicator-edit span {
        width: 6px; height: 6px; border-radius: 50%;
        background: #cbd5e1; display: block;
        transition: background 0.2s, width 0.2s;
    }
    .tab-steps-indicator-edit span.active {
        background: #0ea573; width: 18px; border-radius: 3px;
    }

    /* ─── Footer ─── */
    #editModal .modal-footer {
        border-top: 1px solid #edf2f7;
        padding: 1rem 1.75rem;
        background: #f8f9fc;
    }
    #editModal .btn-save-student {
        background: linear-gradient(135deg, #0ea573 0%, #057a52 100%);
        border: none; border-radius: 9px; font-weight: 700;
        padding: 0.6rem 1.8rem; letter-spacing: 0.3px; color: #fff;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(14, 165, 115, 0.3);
    }
    #editModal .btn-save-student:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(14, 165, 115, 0.4);
    }
    #editModal .btn-cancel-student {
        border-radius: 9px; font-weight: 600;
        border: 1.5px solid #e3e6f0; color: #6c7a9c; background: #fff;
    }

    /* ══════════════════════════════════════════
       DARK THEME OVERRIDES
    ══════════════════════════════════════════ */
    .dark-theme #editModal .modal-content {
        background: #1e212b;
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }
    .dark-theme #editModal .modal-header {
        background: linear-gradient(135deg, #0a7a56 0%, #044d35 100%);
    }
    .dark-theme .nav-tabs-edit-student {
        background: #14161f;
        border-bottom-color: rgba(255,255,255,0.07);
    }
    .dark-theme .nav-tabs-edit-student .nav-link { color: #8896b3; }
    .dark-theme .nav-tabs-edit-student .nav-link:hover { color: #3ecf8e; }
    .dark-theme .nav-tabs-edit-student .nav-link.active {
        color: #3ecf8e; border-bottom-color: #3ecf8e;
    }
    .dark-theme .nav-tabs-edit-student .nav-link.active .tab-icon {
        background: rgba(62, 207, 142, 0.15); color: #3ecf8e;
    }
    .dark-theme #editModal .section-label {
        color: #64748b; border-bottom-color: rgba(255,255,255,0.05);
    }
    .dark-theme #editModal .student-code-banner {
        background: rgba(14, 165, 115, 0.08);
        border-color: rgba(14, 165, 115, 0.2);
    }
    .dark-theme #editModal .tab-content { background: #1e212b; }
    .dark-theme #editModal .form-label { color: #cbd5e1; }
    .dark-theme #editModal .form-control-modern {
        background: #14161f; border-color: rgba(255,255,255,0.1); color: #e2e8f0;
    }
    .dark-theme #editModal .form-control-modern:focus {
        background: #14161f; border-color: #0ea573; color: #fff;
    }
    .dark-theme #editModal .input-group-text {
        background: #1a1d28; border-color: rgba(255,255,255,0.1); color: #3ecf8e;
    }
    .dark-theme #editModal .modal-footer {
        background: #14161f; border-top-color: rgba(255,255,255,0.07);
    }
    .dark-theme #editModal .btn-cancel-student {
        background: #1e212b; border-color: rgba(255,255,255,0.1); color: #8896b3;
    }
    .dark-theme #editModal .btn-cancel-student:hover { background: #242836; }
    .dark-theme #edit_modal_loader p { color: #8896b3; }
</style>

<!-- ══════════════════════════════════════════
     EDIT STUDENT MODAL
══════════════════════════════════════════ -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            {{-- ─── HEADER ─── --}}
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-user-edit mr-2 ml-1 tx-18"></i>
                    {{ trans('admin.students.edit') }}
                    <span class="badge  font-weight-bold ml-2 mr-2 px-2 py-1" id="edit_student_code_badge"
                          style="font-size:0.8rem; border-radius:7px; letter-spacing:1px;"></span>
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action=""
                  method="POST"
                  class="ajax-form"
                  id="editStudentForm"
                  data-modal-id="#editModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf
                @method('PUT')

                <div class="modal-body p-0">

                    {{-- ─── LOADER ─── --}}
                    <div id="edit_modal_loader" class="text-center py-5 d-none">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">{{ trans('admin.global.loading') }}</span>
                        </div>
                        <p>{{ trans('admin.global.loading') }}</p>
                    </div>

                    {{-- ─── CONTENT ─── --}}
                    <div id="edit_modal_content">

                        {{-- ─── NAV TABS ─── --}}
                        <ul class="nav nav-tabs-edit-student" id="editStudentTabs" role="tablist">

                            <li class="nav-item">
                                <a class="nav-link active" id="edit-tab-personal-tab" data-toggle="tab"
                                   href="#edit-tab-personal" role="tab">
                                    <span class="tab-icon"><i class="las la-user"></i></span>
                                    {{ trans('admin.students.student_information') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="edit-tab-academic-tab" data-toggle="tab"
                                   href="#edit-tab-academic" role="tab">
                                    <span class="tab-icon"><i class="las la-graduation-cap"></i></span>
                                    {{ trans('admin.students.academic_information') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="edit-tab-guardian-tab" data-toggle="tab"
                                   href="#edit-tab-guardian" role="tab">
                                    <span class="tab-icon"><i class="las la-user-shield"></i></span>
                                    {{ trans('admin.students.guardian_info') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" id="edit-tab-attachments-tab" data-toggle="tab"
                                   href="#edit-tab-attachments" role="tab">
                                    <span class="tab-icon"><i class="las la-paperclip"></i></span>
                                    {{ trans('admin.students.fields.attachments') }}
                                </a>
                            </li>

                        </ul>

                        {{-- ─── TAB CONTENT ─── --}}
                        <div class="tab-content" id="editStudentTabContent">

                            {{-- ═══════════════════════════════════════
                                 TAB 1 — Personal Details
                            ═══════════════════════════════════════ --}}
                            <div class="tab-pane fade show active" id="edit-tab-personal" role="tabpanel">

                                {{-- Student Code Banner --}}
                                <div class="student-code-banner">
                                    <i class="las la-id-card-alt"></i>
                                    <div>
                                        <div>
                                            <strong>{{ trans('admin.students.fields.student_code') }}:</strong>
                                            <span id="edit_student_code_preview" class="code-value ml-1 mr-1"></span>
                                        </div>
                                        <small>{{ trans('admin.students.student_code_help') }}</small>
                                    </div>
                                </div>

                                {{-- Section: Name --}}
                                <div class="section-label">
                                    <i class="las la-font"></i>
                                    {{ trans('admin.students.fields.name') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.name_ar') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-language"></i></span>
                                                </div>
                                                <input type="text" name="name[ar]" id="edit_name_ar"
                                                       class="form-control form-control-modern"
                                                       placeholder="{{ trans('admin.students.fields.name_ar') }}"
                                                       required minlength="3" maxlength="50" autocomplete="off">
                                            </div>
                                            <span class="text-danger error-text name_ar_error d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.name_en') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-language"></i></span>
                                                </div>
                                                <input type="text" name="name[en]" id="edit_name_en"
                                                       class="form-control form-control-modern"
                                                       placeholder="{{ trans('admin.students.fields.name_en') }}"
                                                       required minlength="3" maxlength="50" autocomplete="off">
                                            </div>
                                            <span class="text-danger error-text name_en_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section: Account --}}
                                <div class="section-label mt-2">
                                    <i class="las la-lock"></i>
                                    {{ trans('admin.students.fields.email') }} & {{ trans('admin.students.fields.password') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('admin.students.fields.email') }}</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-envelope"></i></span>
                                                </div>
                                                <input type="email" name="email" id="edit_email"
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
                                                {{ trans('admin.students.fields.password') }}
                                                <small class="text-muted ml-1">({{ trans('admin.global.optional') }})</small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-key"></i></span>
                                                </div>
                                                <input type="password" name="password" id="edit_password"
                                                       class="form-control form-control-modern"
                                                       minlength="8" maxlength="30">
                                            </div>
                                            <span class="text-danger error-text password_error d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.password_confirmation') }}
                                                <small class="text-muted ml-1">({{ trans('admin.global.optional') }})</small>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-check-circle"></i></span>
                                                </div>
                                                <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                                       class="form-control form-control-modern"
                                                       data-parsley-equalto="#edit_password">
                                            </div>
                                            <span class="text-danger error-text password_confirmation_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Section: Personal --}}
                                <div class="section-label mt-2">
                                    <i class="las la-id-card"></i>
                                    {{ trans('admin.students.personal_information') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.national_id') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-fingerprint"></i></span>
                                                </div>
                                                <input type="text" name="national_id" id="edit_national_id"
                                                       class="form-control form-control-modern numeric-only"
                                                       maxlength="10" required data-parsley-length="[9, 10]">
                                            </div>
                                            <span class="text-danger error-text national_id_error d-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.date_of_birth') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-calendar"></i></span>
                                                </div>
                                                <input class="form-control form-control-modern" id="editDate"
                                                       placeholder="DD-MM-YYYY" type="text" required
                                                       name="date_of_birth" autocomplete="off">
                                            </div>
                                            <span class="text-danger error-text date_of_birth_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.gender') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="gender_id" id="edit_gender_id"
                                                    class="form-control form-control-modern select2" required>
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
                                                {{ trans('admin.students.fields.nationality') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="nationality_id" id="edit_nationality_id"
                                                    class="form-control form-control-modern select2" required>
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
                                                {{ trans('admin.students.fields.blood_type') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="blood_type_id" id="edit_blood_type_id"
                                                    class="form-control form-control-modern select2" required>
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
                                                {{ trans('admin.students.fields.religion') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="religion_id" id="edit_religion_id"
                                                    class="form-control form-control-modern select2" required>
                                                <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                                @foreach($religions as $religion)
                                                    <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text religion_id_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /edit-tab-personal --}}

                            {{-- ═══════════════════════════════════════
                                 TAB 2 — Academic Info
                            ═══════════════════════════════════════ --}}
                            <div class="tab-pane fade" id="edit-tab-academic" role="tabpanel">

                                <div class="section-label">
                                    <i class="las la-graduation-cap"></i>
                                    {{ trans('admin.students.academic_information') }}
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.academic_year') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-calendar-alt"></i></span>
                                                </div>
                                                <select name="academic_year" id="edit_academic_year"
                                                        class="form-control form-control-modern select2" required>
                                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                                    @foreach($academicYears as $year)
                                                        <option value="{{ $year->name }}">{{ $year->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <span class="text-danger error-text academic_year_error d-block"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.grade') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-layer-group"></i></span>
                                                </div>
                                                <select name="grade_id" id="edit_grade_id"
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
                                                {{ trans('admin.students.fields.classroom') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-chalkboard"></i></span>
                                                </div>
                                                <select name="classroom_id" id="edit_classroom_id"
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
                                                {{ trans('admin.students.fields.section') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-users"></i></span>
                                                </div>
                                                <select name="section_id" id="edit_section_id"
                                                        class="form-control form-control-modern select2" required>
                                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --</option>
                                                </select>
                                            </div>
                                            <span class="text-danger error-text section_id_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light mt-3 border rounded-lg p-3" style="font-size:0.82rem;">
                                    <i class="las la-info-circle text-success mr-1 ml-1 tx-16"></i>
                                    {{ trans('admin.students.academic_note') }}
                                </div>

                            </div>{{-- /edit-tab-academic --}}

                            {{-- ═══════════════════════════════════════
                                 TAB 3 — Guardian & Status
                            ═══════════════════════════════════════ --}}
                            <div class="tab-pane fade" id="edit-tab-guardian" role="tabpanel">

                                <div class="section-label">
                                    <i class="las la-user-shield"></i>
                                    {{ trans('admin.students.guardian_info') }}
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('admin.students.fields.guardian') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-user-friends"></i></span>
                                                </div>
                                                <select name="guardian_id" id="edit_guardian_id"
                                                        class="form-control form-control-modern select2" required>
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
                                                {{ trans('admin.students.fields.status') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="las la-toggle-on"></i></span>
                                                </div>
                                                <select name="status" id="edit_status"
                                                        class="form-control form-control-modern" required>
                                                    <option value="1">{{ trans('admin.global.active') }}</option>
                                                    <option value="0">{{ trans('admin.global.disabled') }}</option>
                                                </select>
                                            </div>
                                            <span class="text-danger error-text status_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /edit-tab-guardian --}}

                            {{-- ═══════════════════════════════════════
                                 TAB 4 — Attachments
                            ═══════════════════════════════════════ --}}
                            <div class="tab-pane fade" id="edit-tab-attachments" role="tabpanel">

                                <div class="section-label">
                                    <i class="las la-image"></i>
                                    {{ trans('admin.students.fields.image') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('admin.students.fields.image') }}</label>
                                            <input type="file" class="form-control" name="image"
                                                   id="student_image_edit" accept="image/*">
                                            <span class="text-danger error-text image_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-label mt-3">
                                    <i class="las la-file-alt"></i>
                                    {{ trans('admin.students.fields.attachments') }}
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('admin.students.fields.attachments') }}</label>
                                            <input type="file" class="form-control" name="attachments[]"
                                                   id="student_attachments_edit" multiple>
                                            <span class="text-danger error-text attachments_error d-block"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- /edit-tab-attachments --}}

                        </div>{{-- /tab-content --}}

                        {{-- ─── Dot Indicators ─── --}}
                        <div class="tab-steps-indicator-edit px-3 pb-1" id="editTabIndicator">
                            <span class="active" data-tab="edit-tab-personal"></span>
                            <span data-tab="edit-tab-academic"></span>
                            <span data-tab="edit-tab-guardian"></span>
                            <span data-tab="edit-tab-attachments"></span>
                        </div>

                    </div>{{-- /#edit_modal_content --}}

                </div>{{-- /.modal-body --}}

                {{-- ─── FOOTER ─── --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel-student" data-dismiss="modal">
                        <i class="las la-times mr-1 ml-1"></i>
                        {{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-save-student">
                        <span class="spinner-border spinner-border-sm d-none mr-1 ml-1"></span>
                        <i class="las la-save mr-1 ml-1"></i>
                        {{ trans('admin.global.save_changes') }}
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

            /* ═══════════════════════════════════════
               FILE INPUT HELPERS
            ═══════════════════════════════════════ */
            function safeJson(value, fallback = []) {
                if (Array.isArray(value)) return value;
                if (typeof value !== 'string' || value.trim() === '') return fallback;
                try {
                    const parsed = JSON.parse(value);
                    return Array.isArray(parsed) ? parsed : fallback;
                } catch (e) { return fallback; }
            }

            function initFileInputs(imagePreviewUrl = [], attachmentsPreviewUrls = [], attachmentsConfig = []) {
                if ($('#student_image_edit').data('fileinput'))      $('#student_image_edit').fileinput('destroy');
                if ($('#student_attachments_edit').data('fileinput')) $('#student_attachments_edit').fileinput('destroy');

                $('#student_image_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false, showRemove: true,
                    overwriteInitial: true, initialPreviewAsData: true,
                    initialPreview: imagePreviewUrl,
                    initialPreviewConfig: imagePreviewUrl.length ? [{
                        type: 'image', caption: imagePreviewUrl[0].split('/').pop()
                    }] : [],
                    allowedFileExtensions: ['jpg','jpeg','png','svg','webp'],
                    maxFileSize: 2048, browseOnZoneClick: true,
                });

                $('#student_attachments_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false, showCaption: true,
                    overwriteInitial: false, initialPreviewAsData: true,
                    initialPreview: attachmentsPreviewUrls,
                    initialPreviewConfig: attachmentsConfig,
                    allowedFileExtensions: ['pdf','doc','docx','jpg','jpeg','png','svg','zip'],
                    maxFileSize: 5120, maxFileCount: 5, browseOnZoneClick: true,
                });
            }

            /* ═══════════════════════════════════════
               DOT INDICATOR SYNC
            ═══════════════════════════════════════ */
            $('#editStudentTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                let activeTabId = $(e.target).attr('href').replace('#', '');
                $('#editTabIndicator span').removeClass('active');
                $('#editTabIndicator span[data-tab="' + activeTabId + '"]').addClass('active');
            });

            /* ═══════════════════════════════════════
               EDIT BUTTON CLICK — Populate Modal
            ═══════════════════════════════════════ */
            let _pendingClassroomId = null;
            let _pendingSectionId   = null;

            $(document).on('click', '.edit-btn', function () {
                isInitialLoad = true;

                let button = $(this);

                // ─── Student Code ───
                let studentCode = button.attr('data-student_code') || '';
                $('#edit_student_code_preview').text(studentCode);
                $('#edit_student_code_badge').text(studentCode);

                // ─── File Inputs ───
                let imageUrl    = button.attr('data-image');
                let imageArray  = imageUrl ? [imageUrl] : [];
                let attachments = safeJson(button.attr('data-attachments'), []);
                let configs     = safeJson(button.attr('data-configs'), []);
                initFileInputs(imageArray, attachments, configs);

                // ─── Cascading dropdowns pre-fill ───
                let gradeId       = button.attr('data-grade_id');
                let classroomId   = button.attr('data-classroom_id');
                let classroomName = button.attr('data-classroom_name');
                let sectionId     = button.attr('data-section_id');
                let sectionName   = button.attr('data-section_name');

                _pendingClassroomId = classroomId;
                _pendingSectionId   = sectionId;

                // Pre-fill visible labels immediately
                $('#edit_classroom_id').html(`<option value="${classroomId}" selected>${classroomName}</option>`);
                $('#edit_section_id').html(`<option value="${sectionId}" selected>${sectionName}</option>`);

                // Reset to first tab
                $('#editStudentTabs a[href="#edit-tab-personal"]').tab('show');
                $('#editTabIndicator span').removeClass('active');
                $('#editTabIndicator span[data-tab="edit-tab-personal"]').addClass('active');
            });

            /* ═══════════════════════════════════════
               CASCADING DROPDOWNS
            ═══════════════════════════════════════ */
            $('#edit_grade_id').on('change', function () {
                let gradeId = $(this).val();

                if (!isInitialLoad) {
                    _pendingClassroomId = null;
                    _pendingSectionId   = null;
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
                            if (isInitialLoad && _pendingClassroomId) {
                                $('#edit_classroom_id').empty();
                            }
                            $.each(response.data, function (key, classroom) {
                                $('#edit_classroom_id').append(`<option value="${key}">${classroom}</option>`);
                            });
                            if (_pendingClassroomId) {
                                $('#edit_classroom_id').val(_pendingClassroomId).trigger('change');
                            }
                            isInitialLoad = false;
                        }
                    }
                });
            });

            $('#edit_classroom_id').on('change', function () {
                let classroomId = $(this).val();
                if (!isInitialLoad) {
                    _pendingSectionId = null;
                    resetDropdown('#edit_section_id');
                }
                if (!classroomId) return;

                $.ajax({
                    url: "{{ route('admin.sections.by-classroom') }}",
                    type: "GET",
                    data: { classroom_id: classroomId },
                    success: function (response) {
                        if (response.success) {
                            if (_pendingSectionId) $('#edit_section_id').empty();
                            $.each(response.data, function (key, section) {
                                $('#edit_section_id').append(`<option value="${key}">${section}</option>`);
                            });
                            if (_pendingSectionId) {
                                $('#edit_section_id').val(_pendingSectionId).trigger('change');
                                _pendingSectionId = null;
                            }
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

            /* Reset on close */
            $('#editModal').on('hidden.bs.modal', function () {
                $(this).find('form').trigger('reset');
                $('.error-text').text('');
                isInitialLoad = true;
                $('#edit_student_code_preview').text('');
                $('#edit_student_code_badge').text('');
            });

            /* Numeric Only */
            $(document).on('input', '.numeric-only', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            /* Date Mask */
            $('#editDate').mask('99-99-9999');

        });

    </script>
@endpush
