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
                    {{ trans('admin.Users.students.show') ?? 'Student Profile' }}
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
                            {{ trans('admin.Users.students.fields.student_code') }}:
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
                                {{ trans('admin.Users.students.academic_information') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-layer-group"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.grade') }}</small>
                                        <span id="show_grade" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-chalkboard"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.classroom') }}</small>
                                        <span id="show_classroom" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-secondary mr-3 ml-3"><i class="las la-users"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.section') }}</small>
                                        <span id="show_section" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-warning mr-3 ml-3"><i class="las la-calendar-alt"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.academic_year') }}</small>
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
                                {{ trans('admin.Users.students.personal_information') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-success mr-3 ml-3"><i class="las la-envelope"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.email') }}</small>
                                        <span id="show_email" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-danger mr-3 ml-3"><i class="las la-id-card"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.national_id') }}</small>
                                        <span id="show_national_id" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-birthday-cake"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.date_of_birth') }}</small>
                                        <span id="show_date_of_birth" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-user-shield"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.Users.students.fields.guardian') }}</small>
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
                        <small class="show-label">{{ trans('admin.Users.students.fields.gender') }}</small>
                        <span id="show_gender" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-info"><i class="las la-globe-americas"></i></div>
                        <small class="show-label">{{ trans('admin.Users.students.fields.nationality') }}</small>
                        <span id="show_nationality" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-warning"><i class="las la-praying-hands"></i></div>
                        <small class="show-label">{{ trans('admin.Users.students.fields.religion') }}</small>
                        <span id="show_religion" class="stat-value">—</span>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon ic-danger"><i class="las la-tint"></i></div>
                        <small class="show-label">{{ trans('admin.Users.students.fields.blood_type') }}</small>
                        <span id="show_blood_type" class="stat-value text-danger font-weight-bold">—</span>
                    </div>
                </div>

                {{-- Attachments --}}
                <div id="show_attachments_container" style="display:none;">
                    <div class="student-show-section-card p-3">
                        <h6 class="student-show-section-title mb-3">
                            <span class="section-title-dot bg-warning"></span>
                            <i class="las la-paperclip mr-1 ml-1 text-warning"></i>
                            {{ trans('admin.Users.students.fields.attachments') }}
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
