{{-- Edit Subject Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">

            <div class="modal-header bg-light border-bottom-0 pb-0 position-relative" style="padding: 1.5rem 2rem;">
                <!-- Last Updated Badge -->
                <div class="position-absolute d-none d-md-flex align-items-center bg-white shadow-sm" style="top: 1.5rem; right: 2rem; padding: 0.4rem 0.8rem; border-radius: 30px; border: 1px solid #e3e6f0;" dir="ltr">
                    <span class="sr-only">Last Updated</span>
                    <i class="las la-clock text-warning tx-16 mr-1"></i>
                    <span class="text-muted font-weight-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;" id="edit_last_updated">--</span>
                </div>

                <div class="d-flex align-items-center w-100 pr-5">
                    <div class="mr-3 ml-3" style="flex-shrink: 0;">
                        <span style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #f6c23e, #dda20a); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; box-shadow: 0 4px 12px rgba(246,194,62,0.35);">
                            <i class="las la-pen-square"></i>
                        </span>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold text-dark mb-1" id="editModalLabel">{{ __('admin.Academic.subjects.edit') }}</h5>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ __('admin.Academic.subjects.section_basic_hint') }}</p>
                    </div>
                    <button type="button" class="close mr-auto ml-auto mb-auto mt-2 d-md-none" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; opacity: 0.5; outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <!-- ─── Form Start ─── -->
            <form id="editSubjectForm"
                  action=""
                  method="POST"
                  class="ajax-form"
                  data-modal-id="#editModal"
                  data-parsley-validate>
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 1.5rem 2rem;">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-warning mr-2 ml-2"><i class="las la-language tx-20"></i></span>
                            <h6 class="font-weight-bold mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.85rem; color: #f6c23e;">{{ __('admin.Academic.subjects.section_basic') }}</h6>
                        </div>

                        <div class="row">
                            <!-- Name (AR) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted" style="font-size: 0.8rem;" for="edit_name_ar">
                                    {{ __('admin.Academic.subjects.fields.name_ar') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.02); border-radius: 10px; overflow: hidden;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0 text-primary" style="border: 1.5px solid #e3e6f0;"><i class="las la-pen"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0 pl-0" id="edit_name_ar" name="name[ar]" placeholder="{{ __('admin.Academic.subjects.placeholders.name_ar') }}" style="border: 1.5px solid #e3e6f0; height: 45px;" data-parsley-required="true" required>
                                </div>
                                <span class="text-danger error-text name_ar_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>

                            <!-- Name (EN) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted" style="font-size: 0.8rem;" for="edit_name_en">
                                    {{ __('admin.Academic.subjects.fields.name_en') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group" style="box-shadow: 0 2px 6px rgba(0,0,0,0.02); border-radius: 10px; overflow: hidden;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0 text-info" style="border: 1.5px solid #e3e6f0;"><i class="las la-pen-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control border-left-0 pl-0" id="edit_name_en" name="name[en]" placeholder="{{ __('admin.Academic.subjects.placeholders.name_en') }}" style="border: 1.5px solid #e3e6f0; height: 45px;" data-parsley-required="true" required>
                                </div>
                                <span class="text-danger error-text name_en_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <label class="form-label font-weight-bold text-muted mb-2" style="font-size: 0.8rem;">
                                    {{ __('admin.Academic.subjects.fields.status') }} <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex gap-3" style="gap: 1rem;">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="edit_status_active" name="status" class="custom-control-input" value="1">
                                        <label class="custom-control-label fw-bold" for="edit_status_active" style="cursor: pointer;">
                                            <span class="badge badge-light px-3 py-2 border text-success" style="border-radius: 8px; font-size: 0.85rem;"><i class="las la-check-circle mr-1 ml-1"></i> {{ __('admin.Academic.subjects.active') }}</span>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="edit_status_inactive" name="status" class="custom-control-input" value="0">
                                        <label class="custom-control-label fw-bold" for="edit_status_inactive" style="cursor: pointer;">
                                            <span class="badge badge-light px-3 py-2 border text-danger" style="border-radius: 8px; font-size: 0.85rem;"><i class="las la-times-circle mr-1 ml-1"></i> {{ __('admin.Academic.subjects.inactive') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <span class="text-danger error-text status_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>
                        </div>
                    </div>

                    <hr style="border-top: 1px dashed #e3e6f0; margin: 1.5rem 0;">
                    <div>
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-success mr-2 ml-2"><i class="las la-sitemap tx-20"></i></span>
                            <h6 class="font-weight-bold mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 0.85rem; color: #10b981;">{{ __('admin.Academic.subjects.section_academic') }}</h6>
                        </div>

                        <div class="row">
                            <!-- Specialization -->
                            <div class="col-md-12 mb-3">
                                <label class="form-label font-weight-bold text-muted" style="font-size: 0.8rem;" for="edit_specialization_id">
                                    <i class="las la-layer-group text-warning mr-1 ml-1"></i>{{ __('admin.Academic.subjects.fields.specialization_id') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="edit_specialization_id" name="specialization_id" style="border: 1.5px solid #e3e6f0; height: 45px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);" data-parsley-required="true" required>
                                    <option value="" selected disabled>{{ __('admin.Academic.subjects.choose_specializations') }}</option>
                                    @foreach($lookups['specializations'] as $spec)
                                        <option value="{{ $spec->id }}">{{ $spec->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text specialization_id_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>

                            <!-- Grade  -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted" style="font-size: 0.8rem;" for="edit_grade_id">
                                    <i class="las la-graduation-cap text-primary mr-1 ml-1"></i>{{ __('admin.Academic.subjects.fields.grade_id') }} <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="edit_grade_id" name="grade_id" style="border: 1.5px solid #e3e6f0; height: 45px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02);" data-parsley-required="true" required>
                                    <option value="" selected disabled>{{ __('admin.Academic.subjects.all_grades') }}</option>
                                    @foreach($lookups['grades'] as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text grade_id_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>

                            <!-- Classroom -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold text-muted" style="font-size: 0.8rem;" for="edit_classroom_id">
                                    <i class="las la-chalkboard text-info mr-1 ml-1"></i>{{ __('admin.Academic.subjects.fields.classroom_id') }} <span class="text-danger">*</span>
                                </label>
                                <div class="position-relative">
                                    <select class="form-control" id="edit_classroom_id" name="classroom_id" style="border: 1.5px solid #e3e6f0; height: 45px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); background-color: #f8f9fc;" data-parsley-required="true" required>
                                        <option value="" selected disabled>{{ __('admin.Academic.subjects.classroom_placeholder') }}</option>
                                    </select>
                                    <span class="spinner-border spinner-border-sm text-primary position-absolute" id="edit_classroom_spinner" style="display: none; top: 15px; left: 15px; z-index: 5;" dir="ltr"></span>
                                </div>
                                <span class="text-danger error-text classroom_id_error" style="font-size: 0.75rem; margin-top: 4px; display: block;"></span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ─── Modal Footer ─── -->
                <div class="modal-footer bg-light border-top-0" style="padding: 1.25rem 2rem; border-radius: 0 0 16px 16px;">
                    <span class="text-muted mr-auto ml-auto d-none d-md-inline" style="font-size: 0.8rem;"><i class="las la-info-circle"></i> {{ __('admin.global.required_hint') }}</span>
                    <button type="button" class="btn btn-white shadow-sm" data-dismiss="modal" style="border-radius: 8px; font-weight: 600; padding: 0.6rem 1.25rem;">
                        {{ __('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm" id="saveEditBtn" style="border-radius: 8px; font-weight: 600; padding: 0.6rem 1.75rem; background: linear-gradient(135deg, #f6c23e, #dda20a); border: none;">
                        <i class="las la-save mr-1 ml-1"></i> {{ __('admin.global.save_changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(function () {
    $('body').on('click', '.edit-btn[data-target="#editModal"]', function () {
        var btn = $(this);

        $('#edit_classroom_id').data('preselect', btn.data('classroom_id'));
        $('#edit_last_updated').text(btn.data('updated-at') || '--');
    });

    $('#edit_grade_id').on('change', function () {
        var preSelectId = $('#edit_classroom_id').data('preselect') || null;
        $('#edit_classroom_id').removeData('preselect');
        loadEditClassrooms($(this).val(), preSelectId);
    });

    // load classrooms for grade
    function loadEditClassrooms(gradeId, preSelectId) {
        var select  = $('#edit_classroom_id');
        var spinner = $('#edit_classroom_spinner');

        select.empty()
              .append('<option value="" selected disabled>{{ __('admin.Academic.subjects.classroom_placeholder') }}</option>')
              .prop('disabled', true)
              .css('background-color', '#f8f9fc');

        if (!gradeId) return;

        spinner.show();
        $.get("{{ route('admin.Academic.classrooms.by-grade') }}", { grade_id: gradeId })
            .done(function (response) {
                var classrooms = response.data;
                if (classrooms && Object.keys(classrooms).length > 0) {
                    select.prop('disabled', false).css('background-color', '#fff');
                    $.each(classrooms, function (id, name) {
                        select.append(
                            $('<option>', { value: id, text: name, selected: parseInt(id) === parseInt(preSelectId) })
                        );
                    });
                }
            })
            .always(function () { spinner.hide(); });
    }

    // Reset modal state on close
    $('#editModal').on('hidden.bs.modal', function () {
        $('form', this)[0].reset();
        $('.error-text', this).text('');
        $('#edit_classroom_id').empty()
            .append('<option value="" selected disabled>{{ __('admin.Academic.subjects.classroom_placeholder') }}</option>')
            .prop('disabled', true).css('background-color', '#f8f9fc');
        $('#edit_last_updated').text('--');
    });

});
</script>
@endpush

<link href="{{ URL::asset('assets/admin/css/LMS/subject/modals.css') }}" rel="stylesheet">
