<!-- Edit Class Period Modal -->
<div class="modal fade" id="editClassPeriodModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-pen mr-1 ml-1"></i>
                    {{ __('admin.class_periods.edit') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" class="ajax-form" data-modal-id="#editClassPeriodModal"
                data-parsley-validate="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        {{-- Name (English) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.name_en') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[en]" id="edit_name_en" class="form-control"
                                    placeholder="{{ __('admin.class_periods.fields.name_en') }}" required minlength="2"
                                    maxlength="255" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>

                        {{-- Name (Arabic) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.name_ar') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" id="edit_name_ar" class="form-control"
                                    placeholder="{{ __('admin.class_periods.fields.name_ar') }}" required minlength="2"
                                    maxlength="255" autocomplete="off" dir="rtl">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        {{-- Grade --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.grade') }}</label>
                                <select name="grade_id" id="edit_grade_id" class="form-control select2-modal-edit">
                                    <option value="">{{ __('admin.class_periods.all_grades') }}</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">{{ __('admin.class_periods.grade_hint') }}</small>
                                <span class="text-danger error-text grade_id_error"></span>
                            </div>
                        </div>

                        {{-- Type (Is Break) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="is_break" id="edit_is_break" class="form-control" required>
                                    <option value="0">{{ __('admin.class_periods.class') }}</option>
                                    <option value="1">{{ __('admin.class_periods.break') }}</option>
                                </select>
                                <span class="text-danger error-text is_break_error"></span>
                            </div>
                        </div>

                        {{-- Start Time --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.start_time') }} <span
                                        class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="edit_start_time" class="form-control"
                                    required autocomplete="off">
                                <span class="text-danger error-text start_time_error"></span>
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.duration') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="duration" id="edit_duration" class="form-control"
                                        placeholder="45" required min="1" max="480" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ __('admin.class_periods.minutes') }}</span>
                                    </div>
                                </div>
                                <span class="text-danger error-text duration_error"></span>
                            </div>
                        </div>

                        {{-- End Time --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.end_time') }} <span
                                        class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="edit_end_time" class="form-control" required
                                    autocomplete="off">
                                <small class="text-muted">{{ __('admin.class_periods.end_time_hint') }}</small>
                                <span class="text-danger error-text end_time_error"></span>
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.sort_order') }}</label>
                                <input type="number" name="sort_order" id="edit_sort_order" class="form-control"
                                    placeholder="1" min="0" autocomplete="off">
                                <small class="text-muted">{{ __('admin.class_periods.sort_order_hint') }}</small>
                                <span class="text-danger error-text sort_order_error"></span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-control" required>
                                    <option value="1">{{ __('admin.global.active') }}</option>
                                    <option value="0">{{ __('admin.global.disabled') }}</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">
                        <span class="spinner-border spinner-border-sm d-none"></span> {{ __('admin.global.save') }}
                    </button>
                    <button class="btn btn-secondary mt-3" data-dismiss="modal"
                        type="button">{{ __('admin.global.cancel') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#editClassPeriodModal .select2-modal-edit').select2({
                dropdownParent: $('#editClassPeriodModal'),
                width: '100%',
                allowClear: true
            });

            // Handle edit button click to populate form
            $(document).on('click', '.edit-btn[data-target="#editClassPeriodModal"]', function() {
                var btn = $(this);
                var modal = $('#editClassPeriodModal');

                modal.find('form').attr('action', btn.data('url'));
                modal.find('#edit_name_en').val(btn.data('name_en'));
                modal.find('#edit_name_ar').val(btn.data('name_ar'));
                modal.find('#edit_start_time').val(btn.data('start_time'));
                modal.find('#edit_end_time').val(btn.data('end_time'));
                modal.find('#edit_duration').val(btn.data('duration'));
                modal.find('#edit_sort_order').val(btn.data('sort_order'));
                modal.find('#edit_is_break').val(btn.data('is_break')).trigger('change');
                modal.find('#edit_status').val(btn.data('status')).trigger('change');
                modal.find('#edit_grade_id').val(btn.data('grade_id')).trigger('change');
            });
        });
    </script>
@endpush
