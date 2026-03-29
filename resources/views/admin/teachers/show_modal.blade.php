<!-- Show Teacher Modal -->
<div class="modal fade" id="showModal">
    <div class="modal-dialog modal-lg text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header d-flex justify-content-between">
                <h6 class="modal-title font-weight-bold"><i class="fas fa-id-badge text-primary mr-1"></i> {{ trans('admin.teachers.show') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <!-- Header Card / Avatar Section -->
                <div class="card user-info-card shadow-sm mb-4 border-0 rounded-lg">
                    <div class="card-body p-3 d-flex align-items-center rounded-lg">
                        <img id="show_image" src="#" alt="Teacher Avatar" class="avatar avatar-xxl brround bg-white shadow-sm mx-4" style="object-fit: cover;">
                        <div>
                            <h4 id="show_name" class="mb-1 font-weight-bold text-dark">Teacher Name</h4>
                            <p id="show_teacher_code" class="text-muted mb-0 font-weight-semibold"><i class="fas fa-barcode"></i> {{ trans('admin.teachers.fields.teacher_code') }}: <span></span></p>
                            <span id="show_status" class="badge badge-success mt-2 px-3 py-1">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Info Sections -->
                <div class="row">
                    <!-- Contact Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-address-book mx-1"></i> {{ trans('admin.teachers.contact_info') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-primary-transparent text-primary mx-3"><i class="fas fa-envelope"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.email') }}</small> <span id="show_email" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-info-transparent text-info mx-3"><i class="fas fa-phone"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.phone') }}</small> <span id="show_phone" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-secondary-transparent text-secondary mx-3"><i class="fas fa-map-marker-alt"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.address') }}</small> <span id="show_address" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>

                    <!-- Personal Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-user-circle mx-1"></i> {{ trans('admin.teachers.teacher_information') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-warning-transparent text-warning mx-3"><i class="fas fa-id-card"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.national_id') }}</small> <span id="show_national_id" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-success-transparent text-success mx-3"><i class="fas fa-calendar-alt"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.joining_date') }}</small> <span id="show_joining_date" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-danger-transparent text-danger mx-3"><i class="fas fa-venus-mars"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.teachers.fields.gender') }}</small> <span id="show_gender" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Demographics -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-globe mx-1"></i> {{ trans('admin.teachers.details') }}</h6>
                        <div class="row text-center teacher-details-grid p-3 m-0 shadow-sm">
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.specializations.title') ?? 'Specialization' }}</small>
                                <span id="show_specialization" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.teachers.fields.nationality') }}</small>
                                <span id="show_nationality" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.teachers.fields.religion') }}</small>
                                <span id="show_religion" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3">
                                <small class="text-muted d-block mb-1">{{ trans('admin.teachers.fields.blood_type') }}</small>
                                <span id="show_blood_type" class="font-weight-bold text-danger"><i class="fas fa-tint mx-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="row" id="show_attachments_container" style="display: none;">
                    <div class="col-12">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-paperclip mx-1"></i> {{ trans('admin.teachers.fields.attachments') }}</h6>
                        <div class="d-flex flex-wrap gap-2" id="show_attachments_list">
                        </div>
                    </div>
                </div>

            </div>

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
        $(document).on('click', '.show-btn', function() {
            let btn = $(this);

            $('#show_name').text(btn.data('name_ar') + ' / ' + btn.data('name_en'));
            $('#show_teacher_code span').text(btn.data('employee_code'));
            $('#show_email').text(btn.data('email'));
            $('#show_phone').text(btn.data('phone') || '-');
            $('#show_address').text(btn.data('address') || '-');
            $('#show_national_id').text(btn.data('national_id'));
            $('#show_joining_date').text(btn.data('joining_date'));
            $('#show_gender').text(btn.data('gender'));
            $('#show_specialization').text(btn.data('specialization') || '-');
            $('#show_nationality').text(btn.data('nationality'));
            $('#show_religion').text(btn.data('religion'));
            $('#show_blood_type').html('<i class="fas fa-tint mr-1"></i> ' + btn.data('blood_type'));

            let statusText = btn.data('status');
            let statusBadge = $('#show_status');
            statusBadge.text(statusText);
            if (statusText === '{{ trans("admin.global.active") }}') {
                statusBadge.removeClass('badge-danger').addClass('badge-success');
            } else {
                statusBadge.removeClass('badge-success').addClass('badge-danger');
            }

            $('#show_image').attr('src', btn.data('image'));

            let attachments = btn.data('attachments') || [];
            let attachContainer = $('#show_attachments_container');
            let attachList = $('#show_attachments_list');

            attachList.empty();

            if(attachments.length > 0) {
                attachContainer.show();
                attachments.forEach(function(att) {
                    let btnHtml = `<a href="${att.url}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm mb-2 mr-2">
                                        <i class="fas fa-download mr-1"></i> ${att.name}
                                       </a>`;
                    attachList.append(btnHtml);
                });
            } else {
                attachContainer.hide();
            }
        });
    </script>
@endpush
