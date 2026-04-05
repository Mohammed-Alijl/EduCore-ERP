<!-- Show Section Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content section-show-modal-content">
            <div class="modal-header section-show-modal-header">
                <h5 class="modal-title font-weight-bold" id="showModalLabel">
                    <i class="las la-info-circle tx-20 mr-1 ml-1 text-primary"></i>
                    {{ __('admin.Academic.sections.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">

                <!-- Section Info Banner -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-primary-transparent border-primary m-0" style="border-radius: 8px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 ml-3">
                                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 10px;">
                                            <i class="las la-users tx-24"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0 tx-18 font-weight-bold tx-primary" id="show-section-name">--</h4>
                                        <small class="text-muted" id="show-section-meta">--</small>
                                    </div>
                                    <div class="ml-auto mr-3">
                                        <span id="show-status-badge" class="badge badge-pill">--</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <h6 class="font-weight-bold tx-14 mb-2">{{ __('admin.Academic.sections.fields.notes') }}</h6>
                    <div class="section-notes-box" id="show-notes">--</div>
                </div>

                <!-- Students List -->
                <div>
                    <h6 class="font-weight-bold tx-14 mb-3 d-flex align-items-center">
                        <i class="las la-user-graduate mr-1 ml-1 text-primary"></i> {{ __('admin.Academic.sections.students_list') }}
                        <span class="badge badge-pill badge-primary ml-auto mr-auto" id="show-students-count">0</span>
                    </h6>

                    <div id="students-loading" class="text-center p-3 d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0" id="students-table">
                            <thead class="section-show-section-card">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.Users.students.fields.student_code') }}</th>
                                    <th>{{ __('admin.Users.students.fields.name') }}</th>
                                    <th>{{ __('admin.Users.students.fields.status') }}</th>
                                </tr>
                            </thead>
                            <tbody id="students-table-body">
                            </tbody>
                        </table>
                    </div>

                    <div id="no-students-empty-state" class="text-center p-4 d-none section-show-empty-state rounded mt-2">
                        <i class="las la-user-slash tx-40 text-muted mb-2"></i>
                        <h6 class="text-muted mb-0">{{ __('admin.Academic.sections.no_students') }}</h6>
                    </div>
                </div>

            </div>
            <div class="modal-footer section-show-modal-footer">
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
        $('#show-section-name').text(btn.data('name_ar') + ' / ' + btn.data('name_en'));
        $('#show-section-meta').text(btn.data('grade_name') + ' — ' + btn.data('classroom_name'));
        $('#show-notes').text(btn.data('notes') || '—');

        var statusBadge = $('#show-status-badge');
        if (btn.data('status') == 1) {
            statusBadge.removeClass('badge-danger').addClass('badge-success').text(btn.data('status_text'));
        } else {
            statusBadge.removeClass('badge-success').addClass('badge-danger').text(btn.data('status_text'));
        }

        // Load students via AJAX
        var studentsUrl = btn.data('students_url');
        var tbody = $('#students-table-body');
        tbody.empty();
        $('#students-table').addClass('d-none');
        $('#no-students-empty-state').addClass('d-none');
        $('#students-loading').removeClass('d-none');
        $('#show-students-count').text('...');

        $.ajax({
            url: studentsUrl,
            success: function (response) {
                $('#students-loading').addClass('d-none');
                var students = response.data || [];

                if (students.length > 0) {
                    $('#students-table').removeClass('d-none');
                    $('#show-students-count').text(students.length);

                    $.each(students, function (index, student) {
                        var statusHtml = student.status == 1
                            ? '<span class="badge badge-modern badge-active"><i class="las la-check-circle mr-1"></i>{{ trans("admin.global.active") }}</span>'
                            : '<span class="badge badge-modern badge-inactive"><i class="las la-times-circle mr-1"></i>{{ trans("admin.global.disabled") }}</span>';

                        tbody.append(
                            '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><code>' + student.student_code + '</code></td>' +
                            '<td>' + student.name + '</td>' +
                            '<td>' + statusHtml + '</td>' +
                            '</tr>'
                        );
                    });
                } else {
                    $('#no-students-empty-state').removeClass('d-none');
                    $('#show-students-count').text('0');
                }
            },
            error: function () {
                $('#students-loading').addClass('d-none');
                $('#show-students-count').text('!');
            }
        });
    });
</script>
@endpush
