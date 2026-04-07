<div class="row row-sm mb-4">
    <div class="col-md-6 col-sm-12 mb-4 mb-md-0">
        <div class="card att-chart-card h-100">
            <div class="card-body p-4">
                <h5 style="font-weight: 700; color: #6366f1; margin-bottom: 1rem;">
                    <i class="las la-chart-bar mr-2 ml-2"></i>
                    {{ trans('admin.Reports.reports.attendance.charts.absences_by_day') }}
                </h5>
                <div id="absences-by-day-chart"></div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-12">
        <div class="card att-chart-card h-100">
            <div class="card-body p-4">
                <h5 style="font-weight: 700; color: #6366f1; margin-bottom: 1rem;">
                    <i class="las la-chart-pie mr-2 ml-2"></i>
                    {{ trans('admin.Reports.reports.attendance.charts.absences_by_grade') }}
                </h5>
                <div id="absences-by-grade-chart" class="d-flex justify-content-center align-items-center" style="min-height: 320px;"></div>
            </div>
        </div>
    </div>
</div>
