<!-- Show Designation Modal -->
<div class="modal fade" id="showDesignationModal" tabindex="-1" role="dialog" aria-labelledby="showDesignationLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content desig-show-modal-content">
            <div class="modal-header desig-show-modal-header">
                <h5 class="modal-title font-weight-bold" id="showDesignationLabel">
                    <i class="las la-info-circle tx-20 mr-1 ml-1 text-primary"></i>
                    {{ __('admin.HR.designations.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <!-- Info Banner -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-primary-transparent border-primary m-0 desig-info-banner">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 ml-3">
                                        <div class="bg-primary text-white desig-icon-box">
                                            <i class="las la-id-badge tx-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0 tx-18 font-weight-bold tx-primary" id="show-desig-name">--</h4>
                                        <small class="text-muted" id="show-desig-department">--</small>
                                    </div>
                                    <div class="ml-auto mr-3">
                                        <span id="show-desig-teach-badge" class="badge badge-pill"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="font-weight-bold tx-14 mb-2">{{ __('admin.HR.designations.fields.description') }}</h6>
                    <div class="desig-description-box" id="show-desig-description">--</div>
                </div>

                <!-- Stats & Details Grid -->
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <div class="desig-stat-card">
                            <div class="desig-stat-value text-purple" id="show-desig-employees-count">0</div>
                            <div class="desig-stat-label">{{ __('admin.HR.designations.fields.employees_count') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="desig-detail-item h-100 d-flex flex-column justify-content-center">
                            <div class="desig-detail-label">{{ __('admin.HR.designations.fields.default_salary') }}</div>
                            <div class="desig-detail-value" id="show-desig-salary">--</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="desig-detail-item h-100 d-flex flex-column justify-content-center">
                            <div class="desig-detail-label">{{ __('admin.HR.designations.fields.department') }}</div>
                            <div class="desig-detail-value" id="show-desig-department-name">--</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer desig-show-modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                    <i class="las la-times"></i> {{ __('admin.global.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.desig-show-btn', function () {
        var btn = $(this);

        $('#show-desig-name').text(btn.data('name'));
        $('#show-desig-department').text(btn.data('department_name') || '--');
        $('#show-desig-department-name').text(btn.data('department_name') || '--');
        $('#show-desig-description').text(btn.data('description') || '{{ __("admin.HR.designations.no_description") }}');
        $('#show-desig-employees-count').text(btn.data('employees_count') || 0);

        var salary = btn.data('default_salary');
        $('#show-desig-salary').text(salary ? parseFloat(salary).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '{{ __("admin.HR.designations.no_salary") }}');

        var teachBadge = $('#show-desig-teach-badge');
        if (btn.data('can_teach') == 1) {
            teachBadge.removeClass('badge-danger').addClass('badge-success').text('{{ __("admin.HR.designations.can_teach_yes") }}');
        } else {
            teachBadge.removeClass('badge-success').addClass('badge-danger').text('{{ __("admin.HR.designations.can_teach_no") }}');
        }
    });
</script>
@endpush
