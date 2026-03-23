<div class="row row-sm mb-4">
    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <div class="grades-kpi-card indigo">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="grades-kpi-label">
                            {{ trans('admin.reports.grades.kpis.total_students') }}
                        </div>
                        <div class="grades-kpi-value mt-2" id="kpi-students">
                            {{ number_format($kpis['total_students']) }}
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-user-graduate"
                                style="font-size: 1.125rem; color: var(--grades-primary); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.reports.grades.kpis.unique_students') }}
                            </span>
                        </div>
                    </div>
                    <div class="grades-kpi-icon-wrapper">
                        <i class="las la-user-graduate grades-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <div class="grades-kpi-card emerald">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="grades-kpi-label">
                            {{ trans('admin.reports.grades.kpis.average_score') }}
                        </div>
                        <div class="grades-kpi-value mt-2" id="kpi-average">
                            {{ $kpis['average_percentage'] }}%
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-percentage"
                                style="font-size: 1.125rem; color: var(--grades-success); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.reports.grades.kpis.overall_avg') }}
                            </span>
                        </div>
                    </div>
                    <div class="grades-kpi-icon-wrapper">
                        <i class="las la-chart-line grades-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <div class="grades-kpi-card amber">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="grades-kpi-label">
                            {{ trans('admin.reports.grades.kpis.pass_rate') }}
                        </div>
                        <div class="grades-kpi-value mt-2" id="kpi-pass-rate">
                            {{ $kpis['pass_rate'] }}%
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-check-double"
                                style="font-size: 1.125rem; color: var(--grades-warning); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.reports.grades.kpis.passing_threshold') }}
                            </span>
                        </div>
                    </div>
                    <div class="grades-kpi-icon-wrapper">
                        <i class="las la-trophy grades-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
        <div class="grades-kpi-card purple">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="grades-kpi-label">
                            {{ trans('admin.reports.grades.kpis.total_exams') }}
                        </div>
                        <div class="grades-kpi-value mt-2" id="kpi-exams">
                            {{ number_format($kpis['total_exams']) }}
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-clipboard-list"
                                style="font-size: 1.125rem; color: var(--grades-purple); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.reports.grades.kpis.exams_with_results') }}
                            </span>
                        </div>
                    </div>
                    <div class="grades-kpi-icon-wrapper">
                        <i class="las la-clipboard-list grades-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
