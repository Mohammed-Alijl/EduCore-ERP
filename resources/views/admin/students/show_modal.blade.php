<!-- Show Student Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content student-show-modal-content">

            {{-- ─── Header ─── --}}
            <div class="modal-header student-show-modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold d-flex align-items-center">
                    <span class="modal-header-icon mr-2 ml-2">
                        <i class="las la-user-graduate"></i>
                    </span>
                    {{ trans('admin.students.show') ?? 'Student Profile' }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ─── Body ─── --}}
            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">

                {{-- Avatar / Identity Banner --}}
                <div class="student-avatar-banner mb-4 d-flex align-items-center p-3">
                    <img id="show_image"
                         src="{{ URL::asset('assets/student/img/faces/boy_student.png') }}"
                         alt="Student Avatar"
                         class="student-avatar-img shadow {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }}">
                    <div class="flex-grow-1">
                        <h4 id="show_name" class="mb-1 font-weight-bold student-show-name">—</h4>
                        <p class="mb-1 student-show-code">
                            <i class="las la-barcode mr-1"></i>
                            {{ trans('admin.students.fields.student_code') }}:
                            <span id="show_student_code_val" class="code-pill">—</span>
                        </p>
                        <span id="show_status" class="badge badge-show-active mt-1">—</span>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="row">
                    {{-- Academic Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="student-show-section-card p-3">
                            <h6 class="student-show-section-title mb-3">
                                <span class="section-title-dot bg-primary"></span>
                                <i class="las la-graduation-cap mr-1 ml-1 text-primary"></i>
                                {{ trans('admin.students.academic_information') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-layer-group"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.grade') }}</small>
                                        <span id="show_grade" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-chalkboard"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.classroom') }}</small>
                                        <span id="show_classroom" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-secondary mr-3 ml-3"><i class="las la-users"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.section') }}</small>
                                        <span id="show_section" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-warning mr-3 ml-3"><i class="las la-calendar-alt"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.academic_year') }}</small>
                                        <span id="show_academic_year" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Personal Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="student-show-section-card p-3">
                            <h6 class="student-show-section-title mb-3">
                                <span class="section-title-dot bg-success"></span>
                                <i class="las la-address-card mr-1 ml-1 text-success"></i>
                                {{ trans('admin.students.personal_information') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-success mr-3 ml-3"><i class="las la-envelope"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.email') }}</small>
                                        <span id="show_email" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-danger mr-3 ml-3"><i class="las la-id-card"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.national_id') }}</small>
                                        <span id="show_national_id" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-birthday-cake"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.date_of_birth') }}</small>
                                        <span id="show_date_of_birth" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-user-shield"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.students.fields.guardian') }}</small>
                                        <span id="show_guardian" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Demographics Stats Row --}}
                <div class="student-stats-row mb-4">
                    <div class="stat-item">
                        <div class="stat-icon ic-primary"><i class="las la-venus-mars"></i></div>
                        <small class="show-label">{{ trans('admin.students.fields.gender') }}</small>
                        <span id="show_gender" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-info"><i class="las la-globe-americas"></i></div>
                        <small class="show-label">{{ trans('admin.students.fields.nationality') }}</small>
                        <span id="show_nationality" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-warning"><i class="las la-praying-hands"></i></div>
                        <small class="show-label">{{ trans('admin.students.fields.religion') }}</small>
                        <span id="show_religion" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-danger"><i class="las la-tint"></i></div>
                        <small class="show-label">{{ trans('admin.students.fields.blood_type') }}</small>
                        <span id="show_blood_type" class="stat-value text-danger font-weight-bold">—</span>
                    </div>
                </div>

                {{-- Attachments --}}
                <div id="show_attachments_container" style="display:none;">
                    <div class="student-show-section-card p-3">
                        <h6 class="student-show-section-title mb-3">
                            <span class="section-title-dot bg-warning"></span>
                            <i class="las la-paperclip mr-1 ml-1 text-warning"></i>
                            {{ trans('admin.students.fields.attachments') }}
                        </h6>
                        <div class="d-flex flex-wrap" id="show_attachments_list"></div>
                    </div>
                </div>

            </div>

            {{-- ─── Footer ─── --}}
            <div class="modal-footer student-show-modal-footer border-0">
                <button type="button" class="btn btn-secondary border-0 px-4" data-dismiss="modal">
                    <i class="las la-times mr-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* ══════════════════════════════════════════════
   STUDENT SHOW MODAL — Light + Dark Theme
══════════════════════════════════════════════ */

/* ── Content ── */
.student-show-modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}

/* ── Header ── */
.student-show-modal-header {
    background: #fff;
    padding: 1.5rem 1.5rem 0.75rem;
}
.modal-header-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    background: rgba(78, 115, 223, 0.12);
    color: #4e73df;
    display: inline-flex;
    align-items: center; justify-content: center;
    font-size: 1.1rem;
}

/* ── Avatar Banner ── */
.student-avatar-banner {
    background: linear-gradient(135deg, #f8f9fc, #eef1fa);
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.05);
}
.student-avatar-img {
    width: 80px; height: 80px;
    border-radius: 14px;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
}
.student-show-name { color: #1e293b; }
.student-show-code { font-size: 0.85rem; color: #64748b; }
.code-pill {
    background: rgba(78,115,223,0.1);
    color: #3b5cd9; border-radius: 6px;
    padding: 1px 8px; font-weight: 700;
    font-size: 0.8rem; letter-spacing: 0.5px;
}
.badge-show-active { font-size: 0.78rem; font-weight: 600; padding: 0.35em 0.9em; border-radius: 20px; }

/* ── Section Cards ── */
.student-show-section-card {
    background: #f8f9fc;
    border-radius: 12px;
    border: 1px solid rgba(0,0,0,0.04);
    height: 100%;
}
.student-show-section-title {
    font-size: 0.82rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.8px;
    color: #475569; margin-bottom: 0;
    display: flex; align-items: center;
}
.section-title-dot {
    width: 6px; height: 6px;
    border-radius: 50%; display: inline-block;
    margin-right: 8px; margin-left: 4px;
}

/* ── Info Items ── */
.show-label { font-size: 0.72rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
.show-value { font-size: 0.9rem; color: #1e293b; }
.show-icon-circle {
    width: 34px; height: 34px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}
.ic-primary   { background: rgba(78,115,223,0.12); color: #4e73df; }
.ic-info      { background: rgba(54,185,204,0.12); color: #36b9cc; }
.ic-success   { background: rgba(28,200,138,0.12); color: #1cc88a; }
.ic-danger    { background: rgba(231,74,59,0.12);  color: #e74a3b; }
.ic-warning   { background: rgba(246,194,62,0.12); color: #f6c23e; }
.ic-secondary { background: rgba(133,135,150,0.12);color: #858796; }

/* ── Stats Row ── */
.student-stats-row {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 12px;
}
@media (max-width: 576px) { .student-stats-row { grid-template-columns: repeat(2, 1fr); } }
.stat-item {
    background: #f8f9fc;
    border: 1px solid rgba(0,0,0,0.04);
    border-radius: 12px;
    padding: 1rem 0.75rem;
    text-align: center;
    display: flex; flex-direction: column; align-items: center; gap: 6px;
}
.stat-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
.stat-value { font-size: 0.88rem; font-weight: 700; color: #1e293b; }

/* ── Footer ── */
.student-show-modal-footer { background: #f8f9fc; padding: 1rem 1.5rem; }

/* ══════════════════════════════════════════════
   DARK THEME OVERRIDES
══════════════════════════════════════════════ */
.dark-theme .student-show-modal-content     { background: #1e212b; }
.dark-theme .student-show-modal-header      { background: #1e212b; }
.dark-theme .student-show-modal-header .modal-title { color: #f1f5f9; }
.dark-theme .student-show-modal-header .close       { color: #94a3b8; }
.dark-theme .modal-header-icon              { background: rgba(78,115,223,0.2); color: #7c9df5; }

.dark-theme .student-avatar-banner {
    background: linear-gradient(135deg, #14161f, #1a1d28);
    border-color: rgba(255,255,255,0.06);
}
.dark-theme .student-avatar-img  { border-color: #2a2d3e; }
.dark-theme .student-show-name   { color: #f1f5f9; }
.dark-theme .student-show-code   { color: #64748b; }
.dark-theme .code-pill           { background: rgba(78,115,223,0.2); color: #93b4ff; }

.dark-theme .student-show-section-card { background: #14161f; border-color: rgba(255,255,255,0.05); }
.dark-theme .student-show-section-title { color: #94a3b8; }

.dark-theme .show-label  { color: #4e5970; }
.dark-theme .show-value  { color: #e2e8f0; }

.dark-theme .stat-item { background: #14161f; border-color: rgba(255,255,255,0.05); }
.dark-theme .stat-value { color: #e2e8f0; }
.dark-theme .show-label  { color: #4e5970; }

.dark-theme .student-show-modal-footer { background: #14161f; }

/* dark section title divider */
.dark-theme .student-show-section-title { border-bottom-color: rgba(255,255,255,0.05) !important; }
</style>

@push('scripts')
<script>
    $(document).on('click', '.show-btn', function () {
        var btn = $(this);

        $('#show_name').text((btn.data('name_ar') || '') + ' / ' + (btn.data('name_en') || ''));
        $('#show_student_code_val').text(btn.data('student_code') || '—');
        $('#show_email').text(btn.data('email') || '—');
        $('#show_national_id').text(btn.data('national_id') || '—');
        $('#show_date_of_birth').text(btn.data('date_of_birth') || '—');

        $('#show_grade').text(btn.data('grade_name') || '—');
        $('#show_classroom').text(btn.data('classroom_name') || '—');
        $('#show_section').text(btn.data('section_name') || '—');
        $('#show_academic_year').text(btn.data('academic_year') || '—');
        $('#show_guardian').text(btn.data('guardian_name') || '—');

        $('#show_gender').text(btn.data('gender') || '—');
        $('#show_nationality').text(btn.data('nationality') || '—');
        $('#show_religion').text(btn.data('religion') || '—');
        $('#show_blood_type').text(btn.data('blood_type') || '—');

        /* Status badge */
        var statusText = btn.data('status');
        var $badge = $('#show_status');
        $badge.text(statusText || '—');
        if (statusText === '{{ trans("admin.global.active") }}') {
            $badge.css({'background':'rgba(16,185,129,0.15)', 'color':'#059669', 'border':'1px solid rgba(16,185,129,0.3)'});
        } else {
            $badge.css({'background':'rgba(239,68,68,0.12)', 'color':'#dc2626', 'border':'1px solid rgba(239,68,68,0.25)'});
        }

        /* Profile image */
        var img = btn.data('image');
        $('#show_image').attr('src', img || "{{ URL::asset('assets/student/img/faces/boy_student.png') }}");

        /* Attachments */
        var attachments = btn.data('attachments') || [];
        if (typeof attachments === 'string') {
            try { attachments = JSON.parse(attachments); } catch(e) { attachments = []; }
        }
        var $container = $('#show_attachments_container');
        var $list = $('#show_attachments_list').empty();
        if (attachments.length > 0) {
            $container.show();
            attachments.forEach(function (url) {
                var name = url.split('/').pop();
                $list.append(
                    '<a href="' + url + '" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm mb-2 mr-2 ml-2">' +
                    '<i class="las la-download mr-1"></i>' + name +
                    '</a>'
                );
            });
        } else {
            $container.hide();
        }
    });
</script>
@endpush
