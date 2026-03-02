<style>
    /* ══════════════════════════════════════════
       ADD STUDENT MODAL — CUSTOM STYLES
    ══════════════════════════════════════════ */

    #addModal .modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    #addModal .modal-header {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        padding: 1.25rem 1.75rem;
        border-bottom: none;
    }
    #addModal .modal-header .modal-title {
        color: #fff;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 0.3px;
    }
    #addModal .modal-header .close {
        color: rgba(255, 255, 255, 0.8);
        opacity: 1;
        text-shadow: none;
        font-size: 1.4rem;
    }
    #addModal .modal-header .close:hover {
        color: #fff;
    }

    /* ─── Tabs ─── */
    .nav-tabs-student {
        border-bottom: 2px solid #e8ecf4;
        padding: 0 1rem;
        background: #f8f9fc;
        flex-wrap: nowrap;
        overflow-x: auto;
    }
    .nav-tabs-student .nav-item {
        white-space: nowrap;
    }
    .nav-tabs-student .nav-link {
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
    .nav-tabs-student .nav-link:hover {
        color: #4e73df;
        background: transparent;
    }
    .nav-tabs-student .nav-link.active {
        color: #4e73df;
        border-bottom-color: #4e73df;
        background: transparent;
        font-weight: 700;
    }
    .nav-tabs-student .nav-link .tab-icon {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: background 0.2s;
    }
    .nav-tabs-student .nav-link.active .tab-icon {
        background: rgba(78, 115, 223, 0.12);
        color: #4e73df;
    }
    .nav-tabs-student .nav-link:not(.active) .tab-icon {
        background: rgba(0, 0, 0, 0.04);
        color: #6c7a9c;
    }

    /* ─── Section Labels ─── */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #94a3b8;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f0f2f8;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-label i {
        color: #4e73df;
        font-size: 0.95rem;
    }

    /* ─── Student Code Banner ─── */
    .student-code-banner {
        background: linear-gradient(135deg, rgba(78,115,223,0.07) 0%, rgba(34,74,190,0.05) 100%);
        border: 1px dashed rgba(78, 115, 223, 0.3);
        border-radius: 10px;
        padding: 0.75rem 1.1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .student-code-banner i {
        color: #4e73df;
        font-size: 1.1rem;
    }
    .student-code-banner .code-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #4e73df;
        letter-spacing: 1px;
    }
    .student-code-banner small {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    /* ─── Form Controls ─── */
    #addModal .form-control-modern {
        border-radius: 8px;
        border: 1.5px solid #e3e6f0;
        padding: 0.55rem 0.9rem;
        font-size: 0.875rem;
        box-shadow: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        height: auto;
    }
    #addModal .form-control-modern:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15);
    }
    #addModal .input-group-text {
        background: #f0f3fb;
        border: 1.5px solid #e3e6f0;
        border-radius: 8px 0 0 8px;
        color: #4e73df;
        font-size: 0.9rem;
    }
    [dir="rtl"] #addModal .input-group-text {
        border-radius: 0 8px 8px 0;
    }

    /* ─── Form Label ─── */
    #addModal .form-label {
        font-size: 0.815rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.35rem;
    }

    /* ─── Error Messages — always below input ─── */
    #addModal .form-group {
        display: flex;
        flex-direction: column;
    }
    
    #addModal .error-text {
        display: block !important;
        width: 100%;
        margin-top: 0.3rem;
        font-size: 0.78rem;
        min-height: 0.9rem;
        order: 99; 
    }

    /* ─── Tab Pane ─── */
    #addModal .tab-content {
        padding: 1.5rem 1.75rem;
        min-height: 340px;
    }

    /* ─── Footer ─── */
    #addModal .modal-footer {
        border-top: 1px solid #edf2f7;
        padding: 1rem 1.75rem;
        background: #f8f9fc;
    }
    #addModal .btn-save-student {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        border: none;
        border-radius: 9px;
        font-weight: 700;
        padding: 0.6rem 1.8rem;
        letter-spacing: 0.3px;
        color: #fff;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
    }
    #addModal .btn-save-student:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(78, 115, 223, 0.4);
    }
    #addModal .btn-cancel-student {
        border-radius: 9px;
        font-weight: 600;
        border: 1.5px solid #e3e6f0;
        color: #6c7a9c;
        background: #fff;
    }

    /* ─── Tab Nav Pills (Mobile indicator) ─── */
    .tab-steps-indicator {
        display: flex;
        justify-content: center;
        gap: 0.35rem;
        padding: 0.5rem 0 0;
    }
    .tab-steps-indicator span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #cbd5e1;
        display: block;
        transition: background 0.2s, width 0.2s;
    }
    .tab-steps-indicator span.active {
        background: #4e73df;
        width: 18px;
        border-radius: 3px;
    }

    /* ══════════════════════════════════════════
       DARK THEME OVERRIDES
    ══════════════════════════════════════════ */
    .dark-theme #addModal .modal-content {
        background: #1e212b;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    .dark-theme #addModal .modal-header {
        background: linear-gradient(135deg, #3a5bc7 0%, #1a3894 100%);
    }
    .dark-theme .nav-tabs-student {
        background: #14161f;
        border-bottom-color: rgba(255, 255, 255, 0.07);
    }
    .dark-theme .nav-tabs-student .nav-link {
        color: #8896b3;
    }
    .dark-theme .nav-tabs-student .nav-link:hover {
        color: #7b96f0;
    }
    .dark-theme .nav-tabs-student .nav-link.active {
        color: #7b96f0;
        border-bottom-color: #7b96f0;
    }
    .dark-theme .nav-tabs-student .nav-link.active .tab-icon {
        background: rgba(123, 150, 240, 0.15);
        color: #7b96f0;
    }
    .dark-theme .section-label {
        color: #64748b;
        border-bottom-color: rgba(255, 255, 255, 0.05);
    }
    .dark-theme .student-code-banner {
        background: rgba(78, 115, 223, 0.08);
        border-color: rgba(78, 115, 223, 0.2);
    }
    .dark-theme #addModal .tab-content {
        background: #1e212b;
    }
    .dark-theme #addModal .form-label {
        color: #cbd5e1;
    }
    .dark-theme #addModal .form-control-modern {
        background: #14161f;
        border-color: rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
    }
    .dark-theme #addModal .form-control-modern:focus {
        background: #14161f;
        border-color: #4e73df;
        color: #fff;
    }
    .dark-theme #addModal .input-group-text {
        background: #1a1d28;
        border-color: rgba(255, 255, 255, 0.1);
        color: #7b96f0;
    }
    .dark-theme #addModal .modal-footer {
        background: #14161f;
        border-top-color: rgba(255, 255, 255, 0.07);
    }
    .dark-theme #addModal .btn-cancel-student {
        background: #1e212b;
        border-color: rgba(255, 255, 255, 0.1);
        color: #8896b3;
    }
    .dark-theme #addModal .btn-cancel-student:hover {
        background: #242836;
    }
</style>

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
                    {{ trans('admin.students.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.students.store') }}"
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#addModal"
                  enctype="multipart/form-data"
                  data-parsley-validate="">
                @csrf

                {{-- ─── NAV TABS ─── --}}
                <ul class="nav nav-tabs-student" id="addStudentTabs" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" id="tab-personal-tab" data-toggle="tab"
                           href="#tab-personal" role="tab">
                            <span class="tab-icon"><i class="las la-user"></i></span>
                            {{ trans('admin.students.student_information') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-academic-tab" data-toggle="tab"
                           href="#tab-academic" role="tab">
                            <span class="tab-icon"><i class="las la-graduation-cap"></i></span>
                            {{ trans('admin.students.academic_information') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-guardian-tab" data-toggle="tab"
                           href="#tab-guardian" role="tab">
                            <span class="tab-icon"><i class="las la-user-shield"></i></span>
                            {{ trans('admin.students.guardian_info') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-attachments-tab" data-toggle="tab"
                           href="#tab-attachments" role="tab">
                            <span class="tab-icon"><i class="las la-paperclip"></i></span>
                            {{ trans('admin.students.fields.attachments') }}
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
                                    <strong>{{ trans('admin.students.fields.student_code') }}:</strong>
                                    <span id="student_code_preview" class="code-value ml-1 mr-1"></span>
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
                                        <input type="text" name="name[ar]" id="name_ar"
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
                                        <input type="text" name="name[en]" id="name_en"
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
                                        {{ trans('admin.students.fields.password') }}
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
                                        {{ trans('admin.students.fields.password_confirmation') }}
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
                                        {{ trans('admin.students.fields.date_of_birth') }}
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
                                        {{ trans('admin.students.fields.gender') }}
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
                                        {{ trans('admin.students.fields.nationality') }}
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
                                        {{ trans('admin.students.fields.blood_type') }}
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
                                        {{ trans('admin.students.fields.religion') }}
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
                                        {{ trans('admin.students.fields.grade') }}
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
                                        {{ trans('admin.students.fields.classroom') }}
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
                                        {{ trans('admin.students.fields.section') }}
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
                            {{ trans('admin.students.academic_note') }}
                        </div>

                    </div>{{-- /tab-academic --}}

                    {{-- ═══════════════════════════════════════
                         TAB 3 — Guardian & Status
                    ═══════════════════════════════════════ --}}
                    <div class="tab-pane fade" id="tab-guardian" role="tabpanel">

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
                                        {{ trans('admin.students.fields.status') }}
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
                            {{ trans('admin.students.fields.image') }}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('admin.students.fields.image') }}</label>
                                    <input type="file" class="form-control" name="image"
                                           id="student_image" accept="image/*">
                                    <span class="text-danger error-text image_error"></span>
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
                    url: "{{ route('admin.students.next-code') }}",
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
                    url: "{{ route('admin.classrooms.by-grade') }}",
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
                    url: "{{ route('admin.sections.by-classroom') }}",
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
