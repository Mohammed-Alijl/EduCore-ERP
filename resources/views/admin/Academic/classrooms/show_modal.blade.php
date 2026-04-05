<!-- Show Classroom Modal -->
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content classroom-show-modal-content">
            <div class="modal-header classroom-show-modal-header">
                <h5 class="modal-title font-weight-bold" id="showModalLabel">
                    <i class="las la-info-circle tx-20 mr-1 ml-1 text-primary"></i> 
                    {{ __('admin.Academic.classrooms.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Classroom Info Banner -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-primary-transparent border-primary m-0" style="border-radius: 8px;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 ml-3">
                                        <div class="bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 10px;">
                                            <i class="las la-layer-group tx-24"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 tx-18 font-weight-bold tx-primary" id="show-classroom-name">--</h4>
                                        <p class="mb-0 tx-13 text-muted"><i class="las la-graduation-cap"></i> <span id="show-grade-name">--</span></p>
                                    </div>
                                    <div class="ml-auto mr-auto">
                                        <span id="show-status-badge" class="badge">--</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="mb-4">
                    <h6 class="font-weight-bold tx-14 mb-2">{{ __('admin.Academic.classrooms.fields.notes') }}</h6>
                    <div class="classroom-notes-box" id="show-notes" style="min-height: 50px;">
                        --
                    </div>
                </div>

                <!-- Sections List -->
                <div>
                    <h6 class="font-weight-bold tx-14 mb-3 d-flex align-items-center">
                        <i class="las la-sitemap mr-1 ml-1 text-primary"></i> {{ __('admin.Academic.classrooms.sections_list') }}
                        <span class="badge badge-pill badge-primary ml-auto mr-auto" id="show-sections-count">0</span>
                    </h6>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 text-md-nowrap" id="sections-table">
                            <thead class="classroom-show-section-card">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('admin.Academic.sections.fields.name') }}</th>
                                    <th>{{ __('admin.Academic.sections.fields.status') }}</th>
                                </tr>
                            </thead>
                            <tbody id="sections-table-body">
                                <!-- Sections will be dynamically populated here via JS -->
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Empty State for Sections -->
                    <div id="no-sections-empty-state" class="text-center p-4 d-none classroom-show-section-card rounded">
                        <i class="las la-folder-open tx-40 text-muted mb-2"></i>
                        <h6 class="text-muted mb-0">{{ __('admin.Academic.classrooms.no_sections') }}</h6>
                    </div>
                </div>

            </div>
            <div class="modal-footer classroom-show-modal-footer">
                <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal"><i class="las la-times"></i> {{ __('admin.global.close') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
                // Handle Show Modal Populating
            $(document).on('click', '.view-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                $('#show-classroom-name').text(btn.data('name'));
                $('#show-grade-name').text(btn.data('grade'));
                $('#show-notes').text(btn.data('notes'));
                
                var statusBadge = $('#show-status-badge');
                if (btn.data('status') == 1) {
                    statusBadge.removeClass('badge-danger').addClass('badge-success').text(btn.data('status_text'));
                } else {
                    statusBadge.removeClass('badge-success').addClass('badge-danger').text(btn.data('status_text'));
                }

                var sections = btn.data('sections');
                var tbody = $('#sections-table-body');
                tbody.empty();
                
                if (sections && sections.length > 0) {
                    $('#sections-table').removeClass('d-none');
                    $('#no-sections-empty-state').addClass('d-none');
                    
                    $('#show-sections-count').text(sections.length);
                    
                    $.each(sections, function(index, section) {
                        var statusHtml = section.status == 1 
                            ? '<span class="label text-success d-flex">{{ __("admin.global.active") }}</span>' 
                            : '<span class="label text-danger d-flex">{{ __("admin.global.disabled") }}</span>';
                            
                        var sectionName = typeof section.name === 'object' 
                            ? (section.name['{{ app()->getLocale() }}'] || Object.values(section.name)[0])
                            : section.name;
                        
                        tbody.append('<tr><td>' + (index + 1) + '</td><td>' + sectionName + '</td><td>' + statusHtml + '</td></tr>');
                    });
                } else {
                    $('#sections-table').addClass('d-none');
                    $('#no-sections-empty-state').removeClass('d-none');
                    $('#show-sections-count').text('0');
                }
            });
</script>
@endpush