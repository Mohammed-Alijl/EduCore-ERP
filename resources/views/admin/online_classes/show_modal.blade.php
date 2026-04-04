@push('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/LMS/online_class/show.css') }}">
@endpush

<div class="modal fade" id="onlineClassShowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content online-class-show-modal-content">

            {{-- ─── Header ─── --}}
            <div class="modal-header online-class-show-modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold d-flex align-items-center">
                    <span class="modal-header-icon mr-2 ml-2">
                        <i class="las la-video"></i>
                    </span>
                    {{ trans('admin.online_classes.show') }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ─── Body ─── --}}
            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">

                {{-- Banner / Class Identity --}}
                <div class="online-class-banner mb-4 d-flex align-items-center p-3">
                    <div class="online-class-icon-box shadow-sm {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                        <i class="las la-chalkboard-teacher"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 id="oc_show_subject" class="mb-1 font-weight-bold online-class-show-subject">—</h4>
                        <p class="mb-1 online-class-show-teacher">
                            <i class="las la-user-tie mr-1 ml-1"></i>
                            <span id="oc_show_teacher">—</span>
                        </p>
                        <span id="oc_show_integration" class="integration-pill mt-1">—</span>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="row">
                    {{-- Academic Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="online-class-section-card p-3">
                            <h6 class="online-class-section-title mb-3">
                                <span class="section-title-dot bg-primary"></span>
                                <i class="las la-graduation-cap mr-1 ml-1 text-primary"></i>
                                {{ trans('admin.students.academic_information') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-layer-group"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.grade') }}</small>
                                        <span id="oc_show_grade" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-chalkboard"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.classroom') }}</small>
                                        <span id="oc_show_classroom" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-secondary mr-3 ml-3"><i class="las la-users"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.section') }}</small>
                                        <span id="oc_show_section" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Timing Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="online-class-section-card p-3">
                            <h6 class="online-class-section-title mb-3">
                                <span class="section-title-dot bg-success"></span>
                                <i class="las la-clock mr-1 ml-1 text-success"></i>
                                {{ trans('admin.online_classes.timing') }}
                            </h6>
                            <ul class="list-unstyled mb-0">
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-success mr-3 ml-3"><i class="las la-calendar-check"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.timing') }}</small>
                                        <span id="oc_show_timing" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-2">
                                    <div class="show-icon-circle ic-warning mr-3 ml-3"><i class="las la-hourglass-half"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.minutes') }}</small>
                                        <span id="oc_show_duration" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                                <li class="show-info-item d-flex align-items-center mb-0">
                                    <div class="show-icon-circle ic-info mr-3 ml-3"><i class="las la-calendar-alt"></i></div>
                                    <div>
                                        <small class="show-label d-block">{{ trans('admin.online_classes.academic_year') }}</small>
                                        <span id="oc_show_academic_year" class="show-value font-weight-semibold">—</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Join Area --}}
                <div class="join-link-container p-4 text-center">
                    <p class="text-muted mb-3"><i class="las la-link mr-1"></i> {{ trans('admin.online_classes.join_link') }}</p>
                    <div id="oc_show_join_link">
                        <span class="text-muted small"><i>{{ trans('admin.global.no_data') }}</i></span>
                    </div>
                </div>

            </div>

            {{-- ─── Footer ─── --}}
            <div class="modal-footer online-class-show-modal-footer border-0">
                <button type="button" class="btn btn-secondary border-0 px-4" data-dismiss="modal">
                    <i class="las la-times mr-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        function resetOnlineClassShowModal() {
            $('#oc_show_subject, #oc_show_teacher, #oc_show_academic_year, #oc_show_integration, #oc_show_grade, #oc_show_classroom, #oc_show_section, #oc_show_timing, #oc_show_duration')
                .text('—');
            $('#oc_show_join_link').html('<span class="text-muted small"><i>{{ trans("admin.global.no_data") }}</i></span>');
        }

        $(document).on('click', '.online-class-show-btn', function() {
            var url = $(this).data('url');

            resetOnlineClassShowModal();
            $('#onlineClassShowModal').modal('show');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (!response.success || !response.data) {
                        return;
                    }

                    var item = response.data;

                    $('#oc_show_subject').text(item.subject || '—');
                    $('#oc_show_teacher').text(item.teacher || '—');
                    $('#oc_show_academic_year').text(item.academic_year || '—');
                    $('#oc_show_integration').text(item.integration || '—');
                    $('#oc_show_grade').text(item.grade || '—');
                    $('#oc_show_classroom').text(item.classroom || '—');
                    $('#oc_show_section').text(item.section || '—');
                    $('#oc_show_timing').text(item.start_at || '—');
                    $('#oc_show_duration').text(item.duration + ' {{ trans("admin.online_classes.minutes") }}' || '—');

                    if (item.join_url) {
                        $('#oc_show_join_link').html(
                            '<a href="' + item.join_url +
                            '" target="_blank" class="btn btn-lg btn-success shadow-sm px-5">' +
                            '<i class="las la-external-link-alt mr-2"></i>' + 
                            '{{ trans("admin.online_classes.join") }}' + 
                            '</a>'
                        );
                    }
                },
                error: function() {
                    $('#onlineClassShowModal').modal('hide');
                    swal('{{ trans("admin.global.error_title") }}',
                        '{{ trans("admin.global.failed") }}', 'error');
                }
            });
        });

        $('#onlineClassShowModal').on('hidden.bs.modal', function() {
            resetOnlineClassShowModal();
        });
    </script>
@endpush
