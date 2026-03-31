<!-- Create Class Period Modal -->
<div class="modal fade" id="createClassPeriodModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">
                    <i class="las la-plus-circle mr-1 ml-1"></i>
                    {{ __('admin.class_periods.add') }}
                </h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.schedule.class_periods.store') }}" method="POST" class="ajax-form"
                data-modal-id="#createClassPeriodModal" data-parsley-validate="">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        {{-- Name (English) --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.name_en') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[en]" class="form-control"
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
                                <input type="text" name="name[ar]" class="form-control"
                                    placeholder="{{ __('admin.class_periods.fields.name_ar') }}" required minlength="2"
                                    maxlength="255" autocomplete="off" dir="rtl">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        {{-- Grade --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.grade') }}</label>
                                <select name="grade_id" class="form-control select2-modal">
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
                                <select name="is_break" class="form-control" required>
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
                                <input type="time" name="start_time" class="form-control" required
                                    autocomplete="off">
                                <span class="text-danger error-text start_time_error"></span>
                            </div>
                        </div>

                        {{-- Duration --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.duration') }} <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="duration" class="form-control" placeholder="45" required
                                        min="1" max="480" value="45" autocomplete="off">
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
                                <input type="time" name="end_time" class="form-control" required autocomplete="off">
                                <small class="text-muted">{{ __('admin.class_periods.end_time_hint') }}</small>
                                <span class="text-danger error-text end_time_error"></span>
                            </div>
                        </div>

                        {{-- Sort Order --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.sort_order') }}</label>
                                <input type="number" name="sort_order" class="form-control" placeholder="1"
                                    min="0" autocomplete="off">
                                <small class="text-muted">{{ __('admin.class_periods.sort_order_hint') }}</small>
                                <span class="text-danger error-text sort_order_error"></span>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ __('admin.class_periods.fields.status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
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
            $('#createClassPeriodModal .select2-modal').select2({
                dropdownParent: $('#createClassPeriodModal'),
                width: '100%',
                allowClear: true
            });
        });
    </script>
@endpush
