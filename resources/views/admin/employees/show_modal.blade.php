<!-- Show Employee Modal -->
<div class="modal fade" id="showEmployeeModal">
    <div class="modal-dialog modal-lg text-center" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header d-flex justify-content-between">
                <h6 class="modal-title font-weight-bold"><i class="fas fa-id-badge text-primary mr-1"></i> {{ trans('admin.employees.show') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                <!-- Header Card / Avatar Section -->
                <div class="card user-info-card shadow-sm mb-4 border-0 rounded-lg">
                    <div class="card-body p-3 d-flex align-items-center rounded-lg">
                        <img id="show_emp_image" src="#" alt="Employee Avatar" class="avatar avatar-xxl brround bg-white shadow-sm mx-4" style="object-fit: cover;">
                        <div>
                            <h4 id="show_emp_name" class="mb-1 font-weight-bold text-dark">Employee Name</h4>
                            <p id="show_emp_code" class="text-muted mb-0 font-weight-semibold"><i class="fas fa-barcode"></i> {{ trans('admin.employees.fields.employee_code') }}: <span></span></p>
                            <p id="show_emp_type_label" class="mb-0"><span class="badge badge-pill badge-primary mt-1"></span></p>
                            <span id="show_emp_status" class="badge badge-success mt-2 px-3 py-1">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Info Sections -->
                <div class="row">
                    <!-- Contact Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-address-book mx-1"></i> {{ trans('admin.employees.contact_info') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-primary-transparent text-primary mx-3"><i class="fas fa-envelope"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.email') }}</small> <span id="show_emp_email" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-info-transparent text-info mx-3"><i class="fas fa-phone"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.phone') }}</small> <span id="show_emp_phone" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-secondary-transparent text-secondary mx-3"><i class="fas fa-map-marker-alt"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.address') }}</small> <span id="show_emp_address" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>

                    <!-- Personal Info -->
                    <div class="col-md-6 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-user-circle mx-1"></i> {{ trans('admin.employees.employee_information') }}</h6>
                        <ul class="list-unstyled mb-0 list-item-spacing">
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-warning-transparent text-warning mx-3"><i class="fas fa-id-card"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.national_id') }}</small> <span id="show_emp_national_id" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-success-transparent text-success mx-3"><i class="fas fa-calendar-alt"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.joining_date') }}</small> <span id="show_emp_joining_date" class="font-weight-semibold"></span></div>
                            </li>
                            <li class="mb-2 d-flex align-items-center">
                                <div class="icon-circle bg-danger-transparent text-danger mx-3"><i class="fas fa-venus-mars"></i></div>
                                <div><small class="text-muted d-block">{{ trans('admin.employees.fields.gender') }}</small> <span id="show_emp_gender" class="font-weight-semibold"></span></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Demographics -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <h6 class="teacher-section-heading"><i class="fas fa-globe mx-1"></i> {{ trans('admin.employees.details') }}</h6>
                        <div class="row text-center teacher-details-grid p-3 m-0 shadow-sm">
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.specializations.title') ?? 'Specialization' }}</small>
                                <span id="show_emp_specialization" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.employees.fields.nationality') }}</small>
                                <span id="show_emp_nationality" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3 {{ app()->getLocale() == 'ar' ? 'border-left' : 'border-right' }}">
                                <small class="text-muted d-block mb-1">{{ trans('admin.employees.fields.religion') }}</small>
                                <span id="show_emp_religion" class="font-weight-bold text-dark"></span>
                            </div>
                            <div class="col-3">
                                <small class="text-muted d-block mb-1">{{ trans('admin.employees.fields.blood_type') }}</small>
                                <span id="show_emp_blood_type" class="font-weight-bold text-danger"><i class="fas fa-tint mx-1"></i></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="row" id="show_emp_attachments_container" style="display: none;">
                    <div class="col-12">
                        <h6 class="text-primary font-weight-bold mb-3 border-bottom pb-2"><i class="fas fa-paperclip mx-1"></i> {{ trans('admin.employees.fields.attachments') }}</h6>
                        <div class="d-flex flex-wrap gap-2" id="show_emp_attachments_list">
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
        $(document).on('click', '.emp-show-btn', function() {
            let btn = $(this);

            $('#show_emp_name').text(btn.data('name_ar') + ' / ' + btn.data('name_en'));
            $('#show_emp_code span').text(btn.data('employee_code'));
            $('#show_emp_type_label .badge').text(btn.data('type'));
            $('#show_emp_email').text(btn.data('email'));
            $('#show_emp_phone').text(btn.data('phone') || '-');
            $('#show_emp_address').text(btn.data('address') || '-');
            $('#show_emp_national_id').text(btn.data('national_id'));
            $('#show_emp_joining_date').text(btn.data('joining_date'));
            $('#show_emp_gender').text(btn.data('gender'));
            $('#show_emp_specialization').text(btn.data('specialization') || '-');
            $('#show_emp_nationality').text(btn.data('nationality'));
            $('#show_emp_religion').text(btn.data('religion'));
            $('#show_emp_blood_type').html('<i class="fas fa-tint mr-1"></i> ' + btn.data('blood_type'));

            let statusText = btn.data('status');
            let statusBadge = $('#show_emp_status');
            statusBadge.text(statusText);
            if (statusText === '{{ trans("admin.global.active") }}') {
                statusBadge.removeClass('badge-danger').addClass('badge-success');
            } else {
                statusBadge.removeClass('badge-success').addClass('badge-danger');
            }

            $('#show_emp_image').attr('src', btn.data('image'));

            let attachments = btn.data('attachments') || [];
            let attachContainer = $('#show_emp_attachments_container');
            let attachList = $('#show_emp_attachments_list');

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
