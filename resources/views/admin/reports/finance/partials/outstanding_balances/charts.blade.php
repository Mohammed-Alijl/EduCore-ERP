    <div class="row row-sm mb-4">
        <div class="col-xl-8 col-lg-12">
            <div class="card"
                style="border-radius: 16px; border: 1px solid rgba(67, 97, 238, 0.1); box-shadow: 0 8px 32px rgba(31, 38, 135, 0.12);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #4361ee; margin-bottom: 1rem;">
                        <i class="las la-chart-area mr-2 ml-2"></i>
                        {{ trans('admin.reports.financial.charts.revenue_trend') }}
                    </h5>
                    <div id="revenue-trend-chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12">
            <div class="card"
                style="border-radius: 16px; border: 1px solid rgba(67, 97, 238, 0.1); box-shadow: 0 8px 32px rgba(31, 38, 135, 0.12);">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #4361ee; margin-bottom: 1rem;">
                        <i class="las la-chart-pie mr-2 ml-2"></i>
                        {{ trans('admin.reports.financial.charts.distribution') }}
                    </h5>
                    <div id="student-distribution-chart"></div>
                </div>
            </div>
        </div>
    </div>
