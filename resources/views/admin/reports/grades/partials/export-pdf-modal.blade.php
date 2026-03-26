{{-- PDF Export Modal --}}
<div class="modal fade" id="exportPdfModal" tabindex="-1" role="dialog" aria-labelledby="exportPdfModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exportPdfModalLabel">
                    <i class="las la-file-pdf mr-2"></i>
                    {{ trans('admin.exports.grades_report_pdf.modal_title') }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="grades-export-pdf-form">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        {{ trans('admin.exports.grades_report_pdf.modal_description') }}
                    </p>

                    <div class="row">
                        {{-- Academic Year --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-calendar mr-1"></i>
                                {{ trans('admin.reports.grades.filters.academic_year') }}
                            </label>
                            <select class="form-control" id="export-pdf-academic-year" name="academic_year_id">
                                @foreach ($filterData['academicYears'] as $year)
                                    <option value="{{ $year->id }}"
                                        @if ($year->is_current) selected data-current="true" @endif>
                                        {{ $year->name }}
                                        @if ($year->is_current)
                                            ★
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Grade --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-layer-group mr-1"></i>
                                {{ trans('admin.reports.grades.filters.grade') }}
                            </label>
                            <select class="form-control" id="export-pdf-grade" name="grade_id">
                                @foreach ($filterData['grades'] as $grade)
                                    <option value="{{ $grade->id }}">
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Classroom --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-school mr-1"></i>
                                {{ trans('admin.reports.grades.filters.classroom') }}
                            </label>
                            <select class="form-control" id="export-pdf-classroom" name="classroom_id">
                                <option value="">{{ trans('admin.reports.grades.filters.select_classroom') }}
                                </option>
                            </select>
                        </div>

                        {{-- Section --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-th-large mr-1"></i>
                                {{ trans('admin.reports.grades.filters.section') }}
                            </label>
                            <select class="form-control" id="export-pdf-section" name="section_id">
                                <option value="">{{ trans('admin.reports.grades.filters.select_section') }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Subject --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-book mr-1"></i>
                                {{ trans('admin.reports.grades.filters.subject') }}
                            </label>
                            <select class="form-control" id="export-pdf-subject" name="subject_id">
                                <option value="">{{ trans('admin.reports.grades.filters.all_subjects') }}
                                </option>
                                @foreach ($filterData['subjects'] as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Exam --}}
                        <div class="col-md-6 form-group">
                            <label class="form-label font-weight-bold">
                                <i class="las la-file-alt mr-1"></i>
                                {{ trans('admin.reports.grades.filters.exam') }}
                            </label>
                            <select class="form-control" id="export-pdf-exam" name="exam_id">
                                <option value="">{{ trans('admin.reports.grades.filters.all_exams') }}</option>
                                @foreach ($filterData['exams'] as $exam)
                                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="las la-info-circle mr-1"></i>
                        {{ trans('admin.exports.grades_report_pdf.info_message') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        {{ trans('admin.global.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger" id="btn-submit-pdf-export">
                        <i class="las la-file-export mr-1"></i>
                        {{ trans('admin.exports.grades_report_pdf.generate_button') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
