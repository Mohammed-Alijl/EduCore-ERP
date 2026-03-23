<div class="row row-sm">
    <div class="col-12">
        <div class="grades-table-card">
            <div class="grades-section-header">
                <div class="d-flex align-items-center justify-content-between flex-wrap">
                    <div>
                        <h3 class="grades-section-title mb-0">
                            {{ trans('admin.reports.grades.table.title') }}
                        </h3>
                        <p class="grades-section-subtitle mb-0">
                            {{ trans('admin.reports.grades.table.subtitle') }}
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <span class="badge badge-primary"
                            style="padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600; border-radius: 10px; background: linear-gradient(135deg, #6366f1, #818cf8);">
                            <i class="las la-database mr-1 ml-1"></i>
                            <span id="records-count">0</span>
                            {{ trans('admin.reports.grades.table.records') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body pt-3 pb-4 px-3">
                <div class="table-responsive">
                    <table class="table text-md-nowrap table-hover mb-0" id="grades_report_table" width="100%">
                        <thead>
                            <tr>
                                <th class="wd-5p">#</th>
                                <th>
                                    <i class="las la-user mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.student_name') }}
                                </th>
                                <th>
                                    <i class="las la-layer-group mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.grade') }}
                                </th>
                                <th>
                                    <i class="las la-school mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.classroom') }}
                                </th>
                                <th>
                                    <i class="las la-book mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.subject') }}
                                </th>
                                <th>
                                    <i class="las la-file-alt mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.exam') }}
                                </th>
                                <th class="text-center">
                                    <i class="las la-star mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.score') }}
                                </th>
                                <th class="text-center">
                                    <i class="las la-percentage mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.percentage') }}
                                </th>
                                <th class="text-center">
                                    <i class="las la-check-circle mr-1 ml-1"></i>
                                    {{ trans('admin.reports.grades.table.status') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
