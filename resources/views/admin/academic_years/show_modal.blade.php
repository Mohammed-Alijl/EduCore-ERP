<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content year-show-modal-content">
            <div class="modal-header year-show-modal-header">
                <h5 class="modal-title font-weight-bold">
                    <i class="las la-calendar-alt tx-20 mr-1 ml-1 text-primary"></i>
                    {{ __('admin.academic_years.show') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="year-show-banner mb-4">
                    <h4 id="show_year_name" class="mb-1">-</h4>
                    <p class="mb-0 text-muted">{{ __('admin.academic_years.year_details') }}</p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="year-show-card-item">
                            <small>{{ __('admin.academic_years.fields.starts_at') }}</small>
                            <h6 id="show_year_starts_at" class="mb-0">-</h6>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="year-show-card-item">
                            <small>{{ __('admin.academic_years.fields.ends_at') }}</small>
                            <h6 id="show_year_ends_at" class="mb-0">-</h6>
                        </div>
                    </div>
                    <div class="col-md-12 mb-0">
                        <div class="year-show-card-item">
                            <small>{{ __('admin.academic_years.fields.is_current') }}</small>
                            <h6 id="show_year_current" class="mb-0">-</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer year-show-modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ __('admin.global.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
