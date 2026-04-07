<div class="row row-sm mb-4">
    {{-- Absent Today --}}
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="att-kpi-card rose">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="att-kpi-label">
                            {{ trans('admin.Reports.reports.attendance.kpis.absent_today') }}
                        </div>
                        <div class="att-kpi-value mt-2">
                            {{ number_format($kpis['absent_today']) }}
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-user-times"
                                style="font-size: 1.125rem; color: var(--att-danger); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.Reports.reports.attendance.kpis.absent_today_hint') }}
                            </span>
                        </div>
                    </div>
                    <div class="att-kpi-icon-wrapper">
                        <i class="las la-user-times att-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Average Attendance --}}
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="att-kpi-card emerald">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="att-kpi-label">
                            {{ trans('admin.Reports.reports.attendance.kpis.average_attendance') }}
                        </div>
                        <div class="att-kpi-value mt-2">
                            {{ $kpis['average_attendance'] }}%
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-percentage"
                                style="font-size: 1.125rem; color: var(--att-success); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.Reports.reports.attendance.kpis.average_attendance_hint') }}
                            </span>
                        </div>
                    </div>
                    <div class="att-kpi-icon-wrapper">
                        <i class="las la-chart-line att-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- At-Risk Students --}}
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
        <div class="att-kpi-card amber">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <div class="att-kpi-label">
                            {{ trans('admin.Reports.reports.attendance.kpis.at_risk') }}
                        </div>
                        <div class="att-kpi-value mt-2">
                            {{ number_format($kpis['at_risk_count']) }}
                        </div>
                        <div class="mt-3 d-flex align-items-center">
                            <i class="las la-exclamation-triangle"
                                style="font-size: 1.125rem; color: var(--att-warning); opacity: 0.7;"></i>
                            <span class="ml-2 mr-2" style="font-size: 0.8125rem; font-weight: 600; color: #6c757d;">
                                {{ trans('admin.Reports.reports.attendance.kpis.at_risk_hint') }}
                            </span>
                        </div>
                    </div>
                    <div class="att-kpi-icon-wrapper">
                        <i class="las la-exclamation-triangle att-kpi-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
