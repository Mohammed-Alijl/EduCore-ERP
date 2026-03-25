{{-- PDF Export Modal --}}
<div class="modal fade" id="exportPdfModal" tabindex="-1" role="dialog" aria-labelledby="exportPdfModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exportPdfModalLabel">
                    <i class="las la-file-pdf mr-2"></i>
                    {{ trans('admin.exports.attendance_report_pdf.modal_title') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="export-pdf-form">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        {{ trans('admin.exports.attendance_report_pdf.modal_description') }}
                    </p>

                    {{-- Academic Year --}}
                    <div class="form-group">
                        <label class="form-label font-weight-bold">
                            <i class="las la-calendar mr-1"></i>
                            {{ trans('admin.reports.attendance.filters.academic_year') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="export-pdf-academic-year" name="academic_year_id" required>
                            @foreach ($academicYears as $year)
                                <option value="{{ $year->id }}"
                                    {{ $academicYearId == $year->id ? 'selected' : '' }}>
                                    {{ $year->name }}
                                    @if ($year->is_current)
                                        ★
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Grade (Optional) --}}
                    <div class="form-group">
                        <label class="form-label font-weight-bold">
                            <i class="las la-layer-group mr-1"></i>
                            {{ trans('admin.grades.fields.name') }}
                            <span class="text-muted">({{ trans('admin.global.optional') }})</span>
                        </label>
                        <select class="form-control" id="export-pdf-grade" name="grade_id">
                            <option value="">{{ trans('admin.global.all') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Section (Optional) --}}
                    <div class="form-group">
                        <label class="form-label font-weight-bold">
                            <i class="las la-users mr-1"></i>
                            {{ trans('admin.sections.fields.name') }}
                            <span class="text-muted">({{ trans('admin.global.optional') }})</span>
                        </label>
                        <select class="form-control" id="export-pdf-section" name="section_id" disabled>
                            <option value="">{{ trans('admin.global.all') }}</option>
                        </select>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="las la-info-circle mr-1"></i>
                        {{ trans('admin.exports.attendance_report_pdf.info_message') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger" id="btn-submit-pdf-export">
                        <i class="las la-file-export mr-1"></i>
                        {{ trans('admin.exports.attendance_report_pdf.generate_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
