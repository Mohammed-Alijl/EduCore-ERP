    <div class="row row-sm">
        <div class="col-12">
            <div class="glass-table-card">
                <div class="section-header">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h3 class="section-title mb-0">
                                {{ trans('admin.reports.financial.table.title') }}
                            </h3>
                            <p class="section-subtitle mb-0">
                                {{ trans('admin.reports.financial.table.subtitle') }}
                            </p>
                        </div>
                        <div class="mt-3 mt-md-0 d-flex gap-2">
                            @can('export_financial-reports')
                                <button type="button" class="btn btn-danger mr-2 ml-2" id="btn-export-pdf">
                                    <i class="las la-file-pdf mr-1 ml-1"></i>
                                    {{ trans('admin.exports.financial_report_pdf.export_button') }}
                                </button>
                                <button type="button" class="btn btn-success mr-2 ml-2" id="btn-export-excel">
                                    <i class="las la-file-excel mr-1 ml-1"></i>
                                    {{ trans('admin.exports.financial_report.export_button') }}
                                </button>
                            @endcan
                            <span class="badge badge-primary"
                                style="padding: 0.625rem 1.25rem; font-size: 0.875rem; font-weight: 600; border-radius: 10px;">
                                <i class="las la-database mr-1 ml-1"></i>
                                {{ number_format($kpis['defaulters_count']) }}
                                {{ trans('admin.reports.financial.table.records') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3 pb-4 px-3">
                    <div class="table-responsive">
                        <table class="table text-md-nowrap table-hover mb-0" id="outstanding_balances_table"
                            width="100%">
                            <thead>
                                <tr>
                                    <th class="wd-5p">#</th>
                                    <th class="wd-25p">
                                        <i class="las la-user mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.student_name') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-receipt mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.total_charges') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-money-bill-wave mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.total_payments') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-exclamation-triangle mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.net_balance') }}
                                    </th>
                                    <th class="wd-15p">
                                        <i class="las la-calendar-check mr-1 ml-1"></i>
                                        {{ trans('admin.reports.financial.table.last_payment') }}
                                    </th>
                                    <th class="wd-10p text-center">
                                        <i class="las la-cog mr-1 ml-1"></i>
                                        {{ trans('admin.global.actions') }}
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
