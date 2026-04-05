<div class="row row-sm mb-4">
    {{-- Score Distribution Chart --}}
    <div class="col-xl-4 col-lg-12 mb-4 mb-xl-0">
        <div class="card grades-chart-card">
            <div class="card-body p-4">
                <h5 style="font-weight: 700; color: #6366f1; margin-bottom: 1rem;">
                    <i class="las la-chart-bar mr-2 ml-2"></i>
                    {{ trans('admin.Reports.reports.grades.charts.score_distribution') }}
                </h5>
                <div id="score-distribution-chart"></div>
            </div>
        </div>
    </div>

    {{-- Subject Performance Chart --}}
    <div class="col-xl-4 col-lg-12 mb-4 mb-xl-0">
        <div class="card grades-chart-card">
            <div class="card-body p-4">
                <h5 style="font-weight: 700; color: #6366f1; margin-bottom: 1rem;">
                    <i class="las la-bullseye mr-2 ml-2"></i>
                    {{ trans('admin.Reports.reports.grades.charts.subject_performance') }}
                </h5>
                <div id="subject-performance-chart"></div>
            </div>
        </div>
    </div>

    {{-- Grade Comparison Chart --}}
    <div class="col-xl-4 col-lg-12">
        <div class="card grades-chart-card">
            <div class="card-body p-4">
                <h5 style="font-weight: 700; color: #6366f1; margin-bottom: 1rem;">
                    <i class="las la-balance-scale mr-2 ml-2"></i>
                    {{ trans('admin.Reports.reports.grades.charts.grade_comparison') }}
                </h5>
                <div id="grade-comparison-chart"></div>
            </div>
        </div>
    </div>
</div>
