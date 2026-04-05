<!-- Show Guardian Modal -->
<div class="modal fade" id="guardianShowModal">
    <div class="modal-dialog modal-xl text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header d-flex justify-content-between">
                <h6 class="modal-title font-weight-bold">
                    <i class="fas fa-user-shield text-primary mx-1"></i>
                    {{ trans('admin.Users.guardians.show') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4">

                <!-- Hero Header Card -->
                <div class="card guardian-hero-card shadow-sm mb-4 border-0 rounded-lg">
                    <div class="card-body p-4 d-flex align-items-center rounded-lg">
                        <img id="gshow_image"
                             src="{{ URL::asset('assets/guardian/img/faces/default-avatar.png') }}"
                             alt="Guardian Avatar"
                             class="avatar avatar-xxl brround bg-white shadow mx-4"
                             style="object-fit: cover; width: 90px; height: 90px;">
                        <div>
                            <h4 id="gshow_name_father" class="mb-1 font-weight-bold text-dark"></h4>
                            <p class="text-muted mb-1 small">
                                <i class="fas fa-envelope mx-1 text-primary"></i>
                                <span id="gshow_email"></span>
                            </p>
                            <span id="gshow_status" class="badge badge-pill badge-success mt-1 px-3 py-1">
                                {{ trans('admin.global.active') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Father Information -->
                <div class="section-card card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header bg-blue-gradient rounded-top border-0 py-2 px-4">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-male mx-1"></i>
                            {{ trans('admin.Users.guardians.father_information') }}
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Father Name -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-primary-transparent text-primary mx-3 flex-shrink-0">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.name_father') }}</small>
                                        <strong id="gshow_name_father_full" class="text-dark"></strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Father National ID -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-danger-transparent text-danger mx-3 flex-shrink-0">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.national_id_father') }}</small>
                                        <strong id="gshow_national_id_father" class="text-dark"></strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Father Passport -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-warning-transparent text-warning mx-3 flex-shrink-0">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.passport_id_father') }}</small>
                                        <strong id="gshow_passport_id_father" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Father Phone -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-success-transparent text-success mx-3 flex-shrink-0">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.phone_father') }}</small>
                                        <strong id="gshow_phone_father" class="text-dark"></strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Father Job -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-info-transparent text-info mx-3 flex-shrink-0">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.job_father') }}</small>
                                        <strong id="gshow_job_father" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Father Address -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-secondary-transparent text-secondary mx-3 flex-shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.address_father') }}</small>
                                        <strong id="gshow_address_father" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Father Demographics Chips -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="demographics-strip bg-light rounded p-3 d-flex flex-wrap justify-content-around text-center">
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.nationality_father_id') }}</small>
                                        <span id="gshow_nationality_father" class="font-weight-bold text-dark"></span>
                                    </div>
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.blood_type_father_id') }}</small>
                                        <span id="gshow_blood_type_father" class="font-weight-bold text-danger"></span>
                                    </div>
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.religion_father_id') }}</small>
                                        <span id="gshow_religion_father" class="font-weight-bold text-dark"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mother Information -->
                <div class="section-card card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header bg-pink-gradient rounded-top border-0 py-2 px-4">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-female mx-1"></i>
                            {{ trans('admin.Users.guardians.mother_information') }}
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Mother Name -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-pink-transparent text-pink mx-3 flex-shrink-0">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.name_mother') }}</small>
                                        <strong id="gshow_name_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Mother National ID -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-danger-transparent text-danger mx-3 flex-shrink-0">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.national_id_mother') }}</small>
                                        <strong id="gshow_national_id_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Mother Passport -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-warning-transparent text-warning mx-3 flex-shrink-0">
                                        <i class="fas fa-passport"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.passport_id_mother') }}</small>
                                        <strong id="gshow_passport_id_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Mother Phone -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-success-transparent text-success mx-3 flex-shrink-0">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.phone_mother') }}</small>
                                        <strong id="gshow_phone_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Mother Job -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-info-transparent text-info mx-3 flex-shrink-0">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.job_mother') }}</small>
                                        <strong id="gshow_job_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                            <!-- Mother Address -->
                            <div class="col-md-6 mb-3">
                                <div class="info-item d-flex align-items-start">
                                    <div class="icon-circle bg-secondary-transparent text-secondary mx-3 flex-shrink-0">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">{{ trans('admin.Users.guardians.fields.address_mother') }}</small>
                                        <strong id="gshow_address_mother" class="text-dark">—</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mother Demographics Chips -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="demographics-strip bg-light rounded p-3 d-flex flex-wrap justify-content-around text-center">
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.nationality_mother_id') }}</small>
                                        <span id="gshow_nationality_mother" class="font-weight-bold text-dark">—</span>
                                    </div>
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.blood_type_mother_id') }}</small>
                                        <span id="gshow_blood_type_mother" class="font-weight-bold text-danger">—</span>
                                    </div>
                                    <div class="demo-item px-3">
                                        <small class="text-muted d-block mb-1">{{ trans('admin.Users.guardians.fields.religion_mother_id') }}</small>
                                        <span id="gshow_religion_mother" class="font-weight-bold text-dark">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Children / Students Information -->
                <div class="section-card card border-0 shadow-sm rounded-lg mb-4" id="gshow_children_container" style="display: none;">
                    <div class="card-header bg-success-gradient rounded-top border-0 py-2 px-4">
                        <h6 class="mb-0 text-white font-weight-bold">
                            <i class="fas fa-user-graduate mx-1"></i>
                            {{ trans('admin.Users.students.title') ?? 'Students' }}
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row" id="gshow_children_list">
                            <!-- Children will be appended here -->
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="row" id="gshow_attachments_container" style="display: none;">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-lg">
                            <div class="card-header bg-light border-0 py-2 px-4">
                                <h6 class="mb-0 font-weight-bold text-primary">
                                    <i class="fas fa-paperclip mx-1"></i>
                                    {{ trans('admin.Users.guardians.fields.attachments') }}
                                </h6>
                            </div>
                            <div class="card-body px-4 py-3">
                                <div class="d-flex flex-wrap" id="gshow_attachments_list"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /modal-body -->

            <div class="modal-footer pb-4 px-4">
                <button type="button" class="btn btn-secondary px-4 py-2" data-dismiss="modal">
                    <i class="fas fa-times mx-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>



@push('scripts')
<script>
    $(document).on('click', '.guardian-show-btn', function() {
        let btn = $(this);

        // Hero section
        let nameAr = btn.data('name_father_ar') || '';
        let nameEn = btn.data('name_father_en') || '';
        $('#gshow_name_father').text(nameAr && nameEn ? nameAr + ' / ' + nameEn : nameAr || nameEn);
        $('#gshow_name_father_full').text(nameAr && nameEn ? nameAr + ' / ' + nameEn : nameAr || nameEn);
        $('#gshow_email').text(btn.data('email') || '—');

        let statusText  = btn.data('status');
        let statusBadge = $('#gshow_status');
        statusBadge.text(statusText);
        if (parseInt(btn.data('raw_status')) === 1) {
            statusBadge.removeClass('badge-danger').addClass('badge-success').text('{{ trans("admin.global.active") }}');
        } else {
            statusBadge.removeClass('badge-success').addClass('badge-danger').text('{{ trans("admin.global.disabled") }}');
        }

        // Profile image
        let profileImg = btn.data('image');
        $('#gshow_image').attr('src', profileImg || "{{ URL::asset('assets/guardian/img/faces/default-avatar.png') }}");

        // Father fields
        $('#gshow_national_id_father').text(btn.data('national_id_father') || '—');
        $('#gshow_passport_id_father').text(btn.data('passport_id_father') || '—');
        $('#gshow_phone_father').text(btn.data('phone_father') || '—');

        let jobFatherAr = btn.data('job_father_ar') || '';
        let jobFatherEn = btn.data('job_father_en') || '';
        $('#gshow_job_father').text(jobFatherAr && jobFatherEn ? jobFatherAr + ' / ' + jobFatherEn : jobFatherAr || jobFatherEn || '—');

        $('#gshow_address_father').text(btn.data('address_father') || '—');
        $('#gshow_nationality_father').text(btn.data('nationality_father') || '—');
        $('#gshow_blood_type_father').html('<i class="fas fa-tint mx-1"></i>' + (btn.data('blood_type_father') || '—'));
        $('#gshow_religion_father').text(btn.data('religion_father') || '—');

        // Mother fields
        let motherNameAr = btn.data('name_mother_ar') || '';
        let motherNameEn = btn.data('name_mother_en') || '';
        $('#gshow_name_mother').text(motherNameAr && motherNameEn ? motherNameAr + ' / ' + motherNameEn : motherNameAr || motherNameEn || '—');

        $('#gshow_national_id_mother').text(btn.data('national_id_mother') || '—');
        $('#gshow_passport_id_mother').text(btn.data('passport_id_mother') || '—');
        $('#gshow_phone_mother').text(btn.data('phone_mother') || '—');

        let jobMotherAr = btn.data('job_mother_ar') || '';
        let jobMotherEn = btn.data('job_mother_en') || '';
        $('#gshow_job_mother').text(jobMotherAr && jobMotherEn ? jobMotherAr + ' / ' + jobMotherEn : jobMotherAr || jobMotherEn || '—');

        $('#gshow_address_mother').text(btn.data('address_mother') || '—');
        $('#gshow_nationality_mother').text(btn.data('nationality_mother') || '—');
        $('#gshow_blood_type_mother').html('<i class="fas fa-tint mx-1"></i>' + (btn.data('blood_type_mother') || '—'));
        $('#gshow_religion_mother').text(btn.data('religion_mother') || '—');

        // Attachments
        let attachments = btn.data('attachments') || [];
        if (typeof attachments === 'string') {
            try { attachments = JSON.parse(attachments); } catch(e) { attachments = []; }
        }
        let attachContainer = $('#gshow_attachments_container');
        let attachList      = $('#gshow_attachments_list');
        attachList.empty();

        if (attachments.length > 0) {
            attachContainer.show();
            attachments.forEach(function(url) {
                let name   = url.split('/').pop();
                let ext    = name.split('.').pop().toLowerCase();
                let icon   = ['jpg','jpeg','png','svg','webp'].includes(ext) ? 'fa-image' : (ext === 'pdf' ? 'fa-file-pdf' : 'fa-file-alt');
                attachList.append(`<a href="${url}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm mb-2 mx-1">
                                        <i class="fas ${icon} mx-1"></i> ${name}
                                   </a>`);
            });
        } else {
            attachContainer.hide();
        }

        // Children / Students
        let children = btn.data('children') || [];
        if (typeof children === 'string') {
            try { children = JSON.parse(children); } catch(e) { children = []; }
        }
        let childrenContainer = $('#gshow_children_container');
        let childrenList      = $('#gshow_children_list');
        childrenList.empty();

        if (children.length > 0) {
            childrenContainer.show();
            children.forEach(function(child) {
                // Determine margin class based on locale (RTL/LTR)
                let imgMargin = '{{ app()->getLocale() == "ar" ? "ml-3" : "mr-3" }}';
                let html = `
                    <div class="col-md-6 mb-3">
                        <div class="bg-light p-3 rounded shadow-sm border h-100 position-relative student-card" style="cursor: pointer;" data-toggle="collapse" data-target="#childDetails-${child.id}" aria-expanded="false" aria-controls="childDetails-${child.id}">
                            <div class="d-flex align-items-center">
                                <img src="${child.image}" class="avatar avatar-md brround ${imgMargin} bg-white shadow-sm" style="object-fit: cover;">
                                <div>
                                    <h6 class="mb-1 font-weight-bold text-dark">${child.name}</h6>
                                    <p class="mb-0 text-muted small"><i class="fas fa-barcode"></i> ${child.code}</p>
                                    <p class="mb-0 text-muted small"><i class="fas fa-school"></i> ${child.grade} / ${child.classroom}</p>
                                </div>
                                <i class="fas fa-chevron-down {{ app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto' }} text-muted collapse-indicator"></i>
                            </div>

                            <!-- Expandable Details Section -->
                            <div class="collapse mt-3 pt-3 border-top" id="childDetails-${child.id}">
                                <div class="row small">
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.section') }}</span>
                                        <strong class="text-dark">${child.section || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.academic_year') }}</span>
                                        <strong class="text-dark">${child.academic_year || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.date_of_birth') }}</span>
                                        <strong class="text-dark">${child.date_of_birth || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.gender') }}</span>
                                        <strong class="text-dark">${child.gender || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.nationality') }}</span>
                                        <strong class="text-dark">${child.nationality || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.blood_type') }}</span>
                                        <strong class="text-danger">${child.blood_type || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.students.fields.email') }}</span>
                                        <strong class="text-dark">${child.email || '—'}</strong>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <span class="text-muted d-block">{{ trans('admin.Users.admins.fields.status') }}</span>
                                        <span class="badge badge-pill ${parseInt(child.status) === 1 ? 'badge-success' : 'badge-danger'} px-2 py-1">${parseInt(child.status) === 1 ? '{{ trans('admin.global.active') }}' : '{{ trans('admin.global.disabled') }}'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                childrenList.append(html);
            });
        } else {
            childrenContainer.hide();
        }
    });
</script>
@endpush
