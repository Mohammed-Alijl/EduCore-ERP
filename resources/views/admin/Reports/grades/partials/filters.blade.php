<div class="row row-sm mb-4">
    <div class="col-12">
        <div class="grades-filter-card">
            <div class="filter-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="filter-title mb-0">
                            <i class="las la-filter mr-1 ml-1"></i>
                            {{ trans('admin.Reports.reports.grades.filters.title') }}
                        </h4>
                        <p class="filter-subtitle mb-0">
                            {{ trans('admin.Reports.reports.grades.filters.subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="grades-filter-form">
                    <div class="row">
                        {{-- Academic Year --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-calendar mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.academic_year') }}
                            </label>
                            <select class="form-control" id="filter-academic-year" name="academic_year_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.all_years') }}</option>
                                @foreach ($filterData['academicYears'] as $year)
                                    <option value="{{ $year->id }}"
                                        {{ ($filters['academic_year_id'] ?? '') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }}
                                        @if ($year->is_current)
                                            ★
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Grade --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-layer-group mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.grade') }}
                            </label>
                            <select class="form-control" id="filter-grade" name="grade_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.all_grades') }}</option>
                                @foreach ($filterData['grades'] as $grade)
                                    <option value="{{ $grade->id }}"
                                        {{ ($filters['grade_id'] ?? '') == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Classroom --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-school mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.classroom') }}
                            </label>
                            <select class="form-control" id="filter-classroom" name="classroom_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.select_classroom') }}
                                </option>
                            </select>
                        </div>

                        {{-- Section --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-th-large mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.section') }}
                            </label>
                            <select class="form-control" id="filter-section" name="section_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.select_section') }}
                                </option>
                            </select>
                        </div>

                        {{-- Subject --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-book mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.subject') }}
                            </label>
                            <select class="form-control" id="filter-subject" name="subject_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.all_subjects') }}
                                </option>
                                @foreach ($filterData['subjects'] as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ ($filters['subject_id'] ?? '') == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Exam --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-file-alt mr-1 ml-1"></i>
                                {{ trans('admin.Reports.reports.grades.filters.exam') }}
                            </label>
                            <select class="form-control" id="filter-exam" name="exam_id">
                                <option value="">{{ trans('admin.Reports.reports.grades.filters.all_exams') }}</option>
                                @foreach ($filterData['exams'] as $exam)
                                    <option value="{{ $exam->id }}"
                                        {{ ($filters['exam_id'] ?? '') == $exam->id ? 'selected' : '' }}>
                                        {{ $exam->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-2 gap-2">
                        @can('export_grades-reports')
                            <button type="button" class="btn btn-danger mr-2 ml-2" id="btn-export-pdf" data-toggle="modal"
                                data-target="#exportPdfModal">
                                <i class="las la-file-pdf mr-1 ml-1"></i>
                                {{ trans('admin.exports.grades_report_pdf.export_button') }}
                            </button>
                            <button type="button" class="btn btn-success mr-2 ml-2" id="btn-export-excel"
                                data-toggle="modal" data-target="#exportModal">
                                <i class="las la-file-excel mr-1 ml-1"></i>
                                {{ trans('admin.exports.grades_report.export_button') }}
                            </button>
                        @endcan
                        <button type="button" class="btn btn-filter-reset mr-2 ml-2 btn-danger" id="btn-reset-filters">
                            <i class="las la-undo-alt mr-1 ml-1"></i>
                            {{ trans('admin.Reports.reports.grades.filters.reset') }}
                        </button>
                        <button type="submit" class="btn btn-filter-apply">
                            <i class="las la-search mr-1 ml-1"></i>
                            {{ trans('admin.Reports.reports.grades.filters.search') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
