<!-- Show Department Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content dept-show-modal-content">
            <div class="modal-header dept-show-modal-header">
                <h5 class="modal-title font-weight-bold" id="showModalLabel">
                    <i class="las la-info-circle tx-20 mr-1 ml-1 text-primary"></i>
                    {{ __('admin.HR.departments.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <!-- Department Info Banner -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-primary-transparent border-primary m-0 dept-info-banner">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 ml-3">
                                        <div class="bg-primary text-white dept-icon-box">
                                            <i class="las la-building tx-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0 tx-18 font-weight-bold tx-primary" id="show-dept-name">--</h4>
                                        <small class="text-muted" id="show-dept-meta">--</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h6 class="font-weight-bold tx-14 mb-2">{{ __('admin.HR.departments.fields.description') }}</h6>
                    <div class="dept-description-box" id="show-description">--</div>
                </div>

                <!-- Stats Row -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="dept-stat-card">
                            <div class="dept-stat-value text-purple" id="show-employees-count">0</div>
                            <div class="dept-stat-label">{{ __('admin.HR.departments.fields.employees_count') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dept-stat-card">
                            <div class="dept-stat-value text-warning" id="show-designations-count">0</div>
                            <div class="dept-stat-label">{{ __('admin.HR.departments.fields.designations_count') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Designations List -->
                <div>
                    <h6 class="font-weight-bold tx-14 mb-3 d-flex align-items-center">
                        <i class="las la-briefcase mr-1 ml-1 text-primary"></i> {{ __('admin.HR.departments.designations_list') }}
                        <span class="badge badge-pill badge-primary ml-auto mr-auto" id="show-designations-badge">0</span>
                    </h6>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="dept-designations-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.HR.departments.fields.name') }}</th>
                                    <th>{{ __('admin.HR.departments.fields.employees_count') }}</th>
                                </tr>
                            </thead>
                            <tbody id="dept-designations-body">
                            </tbody>
                        </table>
                    </div>

                    <div id="no-designations-empty-state" class="text-center p-4 d-none dept-show-empty-state rounded mt-2">
                        <i class="las la-briefcase tx-40 text-muted mb-2"></i>
                        <h6 class="text-muted mb-0">{{ __('admin.HR.departments.no_designations') }}</h6>
                    </div>
                </div>

            </div>
            <div class="modal-footer dept-show-modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">
                    <i class="las la-times"></i> {{ __('admin.global.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).on('click', '.show-btn', function () {
        var btn = $(this);

        // Populate basic info
        $('#show-dept-name').text(btn.data('name'));
        $('#show-dept-meta').text('{{ __("admin.HR.departments.title") }}');
        $('#show-description').text(btn.data('description') || '{{ __("admin.HR.departments.no_description") }}');
        $('#show-employees-count').text(btn.data('employees_count') || 0);
        $('#show-designations-count').text(btn.data('designations_count') || 0);

        // Populate designations list
        var designations = btn.data('designations') || [];
        var tbody = $('#dept-designations-body');
        tbody.empty();

        if (typeof designations === 'string') {
            try { designations = JSON.parse(designations); } catch(e) { designations = []; }
        }

        var badge = $('#show-designations-badge');
        badge.text(designations.length);

        if (designations.length > 0) {
            $('#dept-designations-table').removeClass('d-none');
            $('#no-designations-empty-state').addClass('d-none');

            $.each(designations, function (index, designation) {
                tbody.append(
                    '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + designation.name + '</td>' +
                    '<td><span class="dept-count-badge badge-employees"><i class="las la-users"></i> ' + (designation.employees_count || 0) + '</span></td>' +
                    '</tr>'
                );
            });
        } else {
            $('#dept-designations-table').addClass('d-none');
            $('#no-designations-empty-state').removeClass('d-none');
        }
    });
</script>
@endpush
