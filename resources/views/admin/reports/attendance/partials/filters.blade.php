<div class="row row-sm mb-4">
    <div class="col-12">
        <div class="att-filter-card">
            <div class="filter-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="filter-title mb-0">
                            <i class="las la-filter mr-1 ml-1"></i>
                            {{ trans('admin.reports.attendance.filters.title') }}
                        </h4>
                        <p class="filter-subtitle mb-0">
                            {{ trans('admin.reports.attendance.filters.subtitle') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                <form id="attendance-filter-form">
                    <div class="row align-items-end">
                        {{-- Academic Year --}}
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-3">
                            <label class="form-label font-weight-bold" style="font-size: 0.8125rem;">
                                <i class="las la-calendar mr-1 ml-1"></i>
                                {{ trans('admin.reports.attendance.filters.academic_year') }}
                            </label>
                            <select class="form-control" id="filter-academic-year" name="academic_year_id">
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

                        {{-- Action Buttons --}}
                        <div class="col-xl-8 col-lg-6 col-md-6 mb-3">
                            <div class="d-flex justify-content-end gap-2">
                                @can('export_attendance-reports')
                                    <button type="button" class="btn btn-danger mr-2 ml-2" id="btn-export-pdf"
                                        data-toggle="modal" data-target="#exportPdfModal">
                                        <i class="las la-file-pdf mr-1 ml-1"></i>
                                        {{ trans('admin.exports.attendance_report_pdf.export_button') }}
                                    </button>
                                    <button type="button" class="btn btn-success mr-2 ml-2" id="btn-export-excel"
                                        data-toggle="modal" data-target="#exportModal">
                                        <i class="las la-file-excel mr-1 ml-1"></i>
                                        {{ trans('admin.exports.attendance_report.export_button') }}
                                    </button>
                                @endcan
                                <button type="button" class="btn btn-filter-reset mr-2 ml-2" id="btn-reset-filters">
                                    <i class="las la-undo-alt mr-1 ml-1"></i>
                                    {{ trans('admin.reports.attendance.filters.reset') }}
                                </button>
                                <button type="submit" class="btn btn-filter-apply">
                                    <i class="las la-search mr-1 ml-1"></i>
                                    {{ trans('admin.reports.attendance.filters.search') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
