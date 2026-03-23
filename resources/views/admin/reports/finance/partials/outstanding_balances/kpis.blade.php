    <div class="row row-sm mb-4">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="kpi-card danger">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.total_outstanding') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-revenue">
                                {{ number_format($kpis['total_expected_revenue'], 2) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-coins"
                                    style="font-size: 1.125rem; color: var(--finance-danger); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.currency') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-hand-holding-usd kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
            <div class="kpi-card primary">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.students_count') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-students">
                                {{ number_format($kpis['defaulters_count']) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-user-graduate"
                                    style="font-size: 1.125rem; color: var(--finance-primary); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.active_students') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-users kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <div class="kpi-card success">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="flex-grow-1">
                            <div class="kpi-label">
                                {{ trans('admin.reports.financial.kpis.average_debt') }}
                            </div>
                            <div class="kpi-value mt-2" id="kpi-average">
                                {{ number_format($kpis['average_debt'], 2) }}
                            </div>
                            <div class="mt-3 d-flex align-items-center">
                                <i class="las la-calculator"
                                    style="font-size: 1.125rem; color: var(--finance-success); opacity: 0.7;"></i>
                                <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                    {{ trans('admin.reports.financial.kpis.per_student') }}
                                </span>
                            </div>
                        </div>
                        <div class="kpi-icon-wrapper">
                            <i class="las la-chart-line kpi-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
