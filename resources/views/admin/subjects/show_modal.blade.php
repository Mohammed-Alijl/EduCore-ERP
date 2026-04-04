{{-- Show Subject Modal --}}
<div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">

            {{-- ─── HERO HEADER ─── --}}
            <div class="position-relative" style="background: linear-gradient(135deg, #1a1c5e 0%, #3a3fbf 50%, #5e72e4 100%); padding: 2.5rem 2rem 4rem;">

                {{-- Close Button --}}
                <button type="button" class="close position-absolute text-white" data-dismiss="modal" aria-label="Close"
                        style="top: 1.25rem; right: 1.5rem; opacity: 0.8; font-size: 1.5rem; outline: none;">
                    <span aria-hidden="true">&times;</span>
                </button>

                {{-- Status Badge (top left) --}}
                <div class="position-absolute" style="top: 1.25rem; left: 1.5rem;">
                    <span id="show_status_badge" class="badge px-3 py-2" style="border-radius: 20px; font-size: 0.8rem; font-weight: 600;"></span>
                </div>

                {{-- Hero Content --}}
                <div class="d-flex align-items-center mt-3">
                    <div class="mr-4 ml-4 flex-shrink-0">
                        <div style="width: 80px; height: 80px; border-radius: 20px; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 2px solid rgba(255,255,255,0.25); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                            <i class="las la-book-reader"></i>
                        </div>
                    </div>
                    <div class="text-white">
                        <p class="mb-1 text-uppercase" style="font-size: 0.7rem; letter-spacing: 2px; opacity: 0.7;">{{ __('admin.subjects.title') }}</p>
                        <h3 class="font-weight-bold mb-1" id="show_name_ar" style="font-size: 1.8rem; text-shadow: 0 2px 8px rgba(0,0,0,0.2);">—</h3>
                        <p class="mb-0" id="show_name_en" style="font-size: 1rem; opacity: 0.75;">—</p>
                    </div>
                </div>
            </div>

            {{-- ─── CARDS GRID (overlapping the hero) ─── --}}
            <div style="margin-top: -2.5rem; padding: 0 1.5rem 1.5rem;">

                {{-- Single Row for all three cards --}}
                <div class="row">

                    {{-- Card 1: Academic Info --}}
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #4e73df, #224abe); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(78,115,223,0.4); flex-shrink: 0;" class="mr-3 ml-3">
                                        <i class="las la-graduation-cap"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 text-uppercase font-weight-bold text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">{{ __('admin.subjects.section_academic') }}</p>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ __('admin.subjects.fields.grade_id') }} &amp; {{ __('admin.subjects.fields.classroom_id') }}</h6>
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed #e3e6f0; margin: 0.75rem 0;">
                                <div class="d-flex align-items-center mb-3">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #eef2ff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" class="mr-3 ml-3">
                                        <i class="las la-layer-group text-primary tx-16"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0" style="font-size: 0.72rem;">{{ __('admin.subjects.fields.grade_id') }}</p>
                                        <p class="font-weight-bold mb-0 text-dark" id="show_grade">—</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #e8f7f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" class="mr-3 ml-3">
                                        <i class="las la-chalkboard text-success tx-16"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0" style="font-size: 0.72rem;">{{ __('admin.subjects.fields.classroom_id') }}</p>
                                        <p class="font-weight-bold mb-0 text-dark" id="show_classroom">—</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Specialization --}}
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #f6c23e, #dda20a); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(246,194,62,0.4); flex-shrink: 0;" class="mr-3 ml-3">
                                        <i class="las la-project-diagram"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 text-uppercase font-weight-bold text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">{{ __('admin.subjects.fields.specialization_id') }}</p>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ __('admin.subjects.fields.specialization_id') }}</h6>
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed #e3e6f0; margin: 0.75rem 0;">
                                <div class="text-center pt-2">
                                    <div style="width: 64px; height: 64px; border-radius: 16px; background: linear-gradient(135deg, #fff3cd, #ffe69c); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                                        <i class="las la-microscope text-warning" style="font-size: 1.8rem;"></i>
                                    </div>
                                    <h5 class="font-weight-bold text-dark mb-0" id="show_specialization">—</h5>
                                    <p class="text-muted mt-1" style="font-size: 0.8rem;">{{ __('admin.subjects.fields.specialization_id') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 3: Quick Stats --}}
                    <div class="col-lg-4 col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <span style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, #1cc88a, #13855c); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; box-shadow: 0 4px 10px rgba(28,200,138,0.4); flex-shrink: 0;" class="mr-3 ml-3">
                                        <i class="las la-chart-bar"></i>
                                    </span>
                                    <div>
                                        <p class="mb-0 text-uppercase font-weight-bold text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">{{ __('admin.global.statistics') }}</p>
                                        <h6 class="mb-0 font-weight-bold text-dark">{{ __('admin.global.overview') }}</h6>
                                    </div>
                                </div>
                                <hr style="border-top: 1px dashed #e3e6f0; margin: 0.75rem 0;">
                                <div class="d-flex justify-content-between align-items-center mb-2" style="background: #eff6ff; border-radius: 12px; padding: 0.75rem 1rem;">
                                    <div><i class="las la-user-graduate text-primary mr-2 ml-2"></i> <span class="text-muted font-weight-bold" style="font-size: 0.8rem;">{{ __('admin.sidebar.students') }}</span></div>
                                    <p class="h5 font-weight-bold text-primary mb-0" id="stat_students">0</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2" style="background: #fefce8; border-radius: 12px; padding: 0.75rem 1rem;">
                                    <div><i class="las la-layer-group text-warning mr-2 ml-2"></i> <span class="text-muted font-weight-bold" style="font-size: 0.8rem;">{{ __('admin.global.sections') }}</span></div>
                                    <p class="h5 font-weight-bold text-warning mb-0" id="stat_sections">0</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="background: #f0fdf4; border-radius: 12px; padding: 0.75rem 1rem;">
                                    <div><i class="las la-chalkboard-teacher text-success mr-2 ml-2"></i> <span class="text-muted font-weight-bold" style="font-size: 0.8rem;">{{ __('admin.sidebar.teachers') }}</span></div>
                                    <p class="h5 font-weight-bold text-success mb-0" id="stat_teachers">0</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>{{-- end single row --}}

            </div>{{-- end cards grid --}}


            {{-- ─── FOOTER ─── --}}
            <div class="modal-footer bg-light border-top-0" style="padding: 1.25rem 2rem; border-radius: 0 0 20px 20px;">
                <small class="text-muted mr-auto ml-auto d-none d-md-inline">
                    <i class="las la-clock mr-1"></i> {{ __('admin.global.save_changes') }}: <span id="show_updated_at" class="font-weight-bold">—</span>
                </small>
                <button type="button" class="btn btn-light shadow-sm" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 0.6rem 1.25rem;">
                    <i class="las la-arrow-left mr-1 ml-1"></i> {{ __('admin.global.cancel') }}
                </button>
                @can('edit_subjects')
                @if(!request()->routeIs('admin.subjects.archived'))
                <a href="javascript:void(0)" class="btn btn-primary shadow-sm show-to-edit-btn"
                   style="border-radius: 8px; font-weight: 600; padding: 0.6rem 1.5rem; background: linear-gradient(135deg, #4e73df, #224abe); border: none;">
                    <i class="las la-pen mr-1 ml-1"></i> {{ __('admin.subjects.edit') }}
                </a>
                @endif
                @endcan
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
$(function () {

    $('body').on('click', '.show-subject-btn', function () {
        var btn = $(this);

        // Hero
        $('#show_name_ar').text(btn.data('name_ar') || '—');
        $('#show_name_en').text(btn.data('name_en') || '—');
        $('#show_updated_at').text(btn.data('updated-at') || '—');

        // Status badge
        var status = parseInt(btn.data('status'));
        var $badge = $('#show_status_badge');
        if (status === 1) {
            $badge.text("{{ __('admin.subjects.active') }}")
                  .css({ background: 'rgba(28,200,138,0.2)', color: '#1cc88a', border: '1px solid rgba(28,200,138,0.4)' });
        } else {
            $badge.text("{{ __('admin.subjects.inactive') }}")
                  .css({ background: 'rgba(231,74,59,0.2)', color: '#e74a3b', border: '1px solid rgba(231,74,59,0.4)' });
        }

        // Academic info
        $('#show_grade').text(btn.data('grade') || '—');
        $('#show_classroom').text(btn.data('classroom') || '—');
        $('#show_specialization').text(btn.data('specialization') || '—');
        $('#stat_students').text(btn.data('students') || '0');
        $('#stat_sections').text(btn.data('sections') || '0');
        $('#stat_teachers').text(btn.data('teachers') || '0');

        $('.show-to-edit-btn').off('click').on('click', function () {
            $('#showModal').modal('hide');
            $('#showModal').one('hidden.bs.modal', function () {
                $('[data-target="#editModal"][data-id="' + btn.data('id') + '"]').trigger('click');
            });
        });

        $('#showModal').modal('show');
    });

    // Reset on close
    $('#showModal').on('hidden.bs.modal', function () {
        $('#show_name_ar, #show_name_en, #show_grade, #show_classroom, #show_specialization, #show_updated_at').text('—');
        $('#show_status_badge').text('').removeAttr('style');
    });

});
</script>
@endpush

<link href="{{ URL::asset('assets/admin/css/LMS/subject/modals.css') }}" rel="stylesheet">
