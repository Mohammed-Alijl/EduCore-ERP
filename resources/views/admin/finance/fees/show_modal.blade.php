@push('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/css/finance/show.css') }}">
@endpush

<div class="modal fade" id="showFeeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content finance-show-modal-content">

            {{-- ─── Header ─── --}}
            <div class="modal-header finance-show-modal-header pb-0">
                <h5 class="modal-title d-flex align-items-center">
                    <span class="modal-header-icon mr-2 ml-2">
                        <i class="las la-file-invoice-dollar"></i>
                    </span>
                    {{ __('admin.finance.fees.show') }}
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ─── Body ─── --}}
            <div class="modal-body p-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">

                {{-- Banner Identity --}}
                <div class="finance-banner mb-4 d-flex justify-content-between p-3">
                    <div class="d-flex align-items-center">
                        <div class="finance-icon-box {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
                            <i class="las la-money-bill-wave"></i>
                        </div>
                        <div>
                            <h4 id="fee_show_title" class="mb-1 finance-show-title font-weight-bold">—</h4>
                            <p class="mb-1 finance-show-category">
                                <i class="las la-tag mr-1 ml-1 text-primary"></i>
                                <span id="fee_show_category">—</span>
                            </p>
                            <span id="fee_show_grade_pill" class="integration-pill mt-1"><i class="las la-graduation-cap"></i> <span id="fee_show_grade_pill_text">—</span></span>
                        </div>
                    </div>
                    
                    <div class="amount-display pr-3 pl-3 my-auto text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                        <div class="amount-label">{{ __('admin.finance.fees.fields.amount') }}</div>
                        <div class="amount-value" id="fee_show_amount">$0.00</div>
                    </div>
                </div>

                {{-- Info Cards --}}
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="finance-section-card p-3">
                            <h6 class="finance-section-title mb-3">
                                <span class="section-title-dot bg-info mr-2 ml-2"></span>
                                <i class="las la-info-circle mr-1 ml-1 text-info"></i>
                                {{ __('admin.students.academic_information') }}
                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="show-info-item d-flex align-items-center border-0">
                                        <div class="show-icon-circle ic-primary mr-3 ml-3"><i class="las la-calendar-alt"></i></div>
                                        <div>
                                            <small class="show-label d-block">{{ __('admin.finance.fees.fields.academic_year') }}</small>
                                            <span id="fee_show_academic_year" class="show-value font-weight-semibold">—</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="show-info-item d-flex align-items-center border-0">
                                        <div class="show-icon-circle ic-success mr-3 ml-3"><i class="las la-layer-group"></i></div>
                                        <div>
                                            <small class="show-label d-block">{{ __('admin.finance.fees.fields.grade') }}</small>
                                            <span id="fee_show_grade" class="show-value font-weight-semibold">—</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="show-info-item d-flex align-items-center border-0">
                                        <div class="show-icon-circle ic-warning mr-3 ml-3"><i class="las la-chalkboard"></i></div>
                                        <div>
                                            <small class="show-label d-block">{{ __('admin.finance.fees.fields.classroom') }}</small>
                                            <span id="fee_show_classroom" class="show-value font-weight-semibold">—</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Description Area --}}
                <div class="finance-description-container p-3">
                    <h6 class="text-primary font-weight-bold mb-2"><i class="las la-file-alt mr-1 ml-1"></i> {{ __('admin.finance.fees.fields.description') }}</h6>
                    <p id="fee_show_description" class="finance-description-text mb-0 pb-1 pt-1">—</p>
                </div>

            </div>

            {{-- ─── Footer ─── --}}
            <div class="modal-footer finance-show-modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
                    <i class="las la-times mr-1 ml-1"></i> {{ trans('admin.global.close') }}
                </button>
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        function resetFeeShowModal() {
            $('#fee_show_title, #fee_show_category, #fee_show_grade_pill_text, #fee_show_amount, #fee_show_academic_year, #fee_show_grade, #fee_show_classroom, #fee_show_description').text('—');
        }

        $(document).on('click', '.show-btn', function() {
            var btn = $(this);
            
            resetFeeShowModal();
            $('#showFeeModal').modal('show');

            var currentLocale = '{{ app()->getLocale() }}';
            var title = currentLocale === 'ar' ? btn.data('title_ar') : btn.data('title_en');

            $('#fee_show_title').text(title || '—');
            $('#fee_show_category').text(btn.data('category_name') || '—');
            $('#fee_show_amount').text('$' + parseFloat(btn.data('amount')).toFixed(2) || '—');
            $('#fee_show_academic_year').text(btn.data('academic_year_name') || '—');
            $('#fee_show_grade').text(btn.data('grade_name') || '—');
            $('#fee_show_grade_pill_text').text(btn.data('grade_name') || '—');
            $('#fee_show_classroom').text(btn.data('classroom_name') || '—');
            $('#fee_show_description').text(btn.data('description') || '—');
            
        });

        $('#showFeeModal').on('hidden.bs.modal', function() {
            resetFeeShowModal();
        });
    </script>
@endpush
