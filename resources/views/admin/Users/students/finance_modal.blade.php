{{--
    Student Finance Modal

    A comprehensive financial overview modal displaying:
    - Summary cards with key financial metrics
    - Invoices, Receipts, Discounts, Vouchers tabs
    - Full ledger transaction history
--}}
<div class="modal-header finance-modal-header border-0 pb-0">
    <div class="d-flex align-items-center flex-grow-1">
        <div class="finance-avatar-wrapper {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}">
            <img src="{{ $student['image_url'] }}" alt="{{ $student['name'] }}" class="finance-avatar-img">
            <span class="finance-status-dot {{ $summary['status']['class'] }}"></span>
        </div>
        <div class="flex-grow-1">
            <h5 class="modal-title font-weight-bold mb-1">
                {{ $student['name'] }}
            </h5>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <span class="badge badge-light-primary finance-code-badge">
                    <i class="las la-barcode {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                    {{ $student['student_code'] }}
                </span>
                @if ($student['grade'])
                    <span class="badge badge-light-secondary">
                        {{ $student['grade'] }} / {{ $student['classroom'] }}
                    </span>
                @endif
            </div>
        </div>
    </div>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body finance-modal-body p-4">
    {{-- Summary Cards Section --}}
    <div class="finance-summary-grid mb-4">
        {{-- Total Invoiced --}}
        <div class="finance-summary-card finance-card-invoiced">
            <div class="finance-card-icon">
                <i class="las la-file-invoice-dollar"></i>
            </div>
            <div class="finance-card-content">
                <span class="finance-card-label">{{ trans('admin.Users.students.finance.total_invoiced') }}</span>
                <span class="finance-card-value">{{ $summary['total_invoiced'] }}</span>
                <span class="finance-card-count">{{ $summary['invoice_count'] }}
                    {{ trans('admin.Users.students.finance.invoices') }}</span>
            </div>
        </div>

        {{-- Total Paid --}}
        <div class="finance-summary-card finance-card-paid">
            <div class="finance-card-icon">
                <i class="las la-money-bill-wave"></i>
            </div>
            <div class="finance-card-content">
                <span class="finance-card-label">{{ trans('admin.Users.students.finance.total_paid') }}</span>
                <span class="finance-card-value">{{ $summary['total_paid'] }}</span>
                <span class="finance-card-count">{{ $summary['receipt_count'] }}
                    {{ trans('admin.Users.students.finance.receipts') }}</span>
            </div>
        </div>

        {{-- Total Discounts --}}
        <div class="finance-summary-card finance-card-discounts">
            <div class="finance-card-icon">
                <i class="las la-percent"></i>
            </div>
            <div class="finance-card-content">
                <span class="finance-card-label">{{ trans('admin.Users.students.finance.total_discounts') }}</span>
                <span class="finance-card-value">{{ $summary['total_discounts'] }}</span>
                <span class="finance-card-count">{{ $summary['discount_count'] }}
                    {{ trans('admin.Users.students.finance.discounts_label') }}</span>
            </div>
        </div>

        {{-- Balance --}}
        <div
            class="finance-summary-card finance-card-balance {{ $summary['balance_raw'] > 0 ? 'outstanding' : 'settled' }}">
            <div class="finance-card-icon">
                <i class="las {{ $summary['status']['icon'] }}"></i>
            </div>
            <div class="finance-card-content">
                <span class="finance-card-label">{{ trans('admin.Users.students.finance.balance') }}</span>
                <span class="finance-card-value">{{ $summary['balance'] }}</span>
                <span class="finance-card-status badge badge-{{ $summary['status']['class'] }}">
                    {{ $summary['status']['label'] }}
                </span>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <ul class="nav nav-tabs finance-nav-tabs" id="financeTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="ledger-tab" data-toggle="tab" href="#ledger" role="tab">
                <i class="las la-book {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                {{ trans('admin.Users.students.finance.tabs.ledger') }}
                <span class="badge badge-secondary">{{ $ledger->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices" role="tab">
                <i class="las la-file-invoice {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                {{ trans('admin.Users.students.finance.tabs.invoices') }}
                <span class="badge badge-danger">{{ $invoices->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="receipts-tab" data-toggle="tab" href="#receipts" role="tab">
                <i class="las la-receipt {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                {{ trans('admin.Users.students.finance.tabs.receipts') }}
                <span class="badge badge-success">{{ $receipts->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="discounts-tab" data-toggle="tab" href="#discounts" role="tab">
                <i class="las la-tags {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                {{ trans('admin.Users.students.finance.tabs.discounts') }}
                <span class="badge badge-info">{{ $discounts->count() }}</span>
            </a>
        </li>
        @if ($vouchers->count() > 0)
            <li class="nav-item">
                <a class="nav-link" id="vouchers-tab" data-toggle="tab" href="#vouchers" role="tab">
                    <i class="las la-undo {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                    {{ trans('admin.Users.students.finance.tabs.vouchers') }}
                    <span class="badge badge-warning">{{ $vouchers->count() }}</span>
                </a>
            </li>
        @endif
    </ul>

    {{-- Tabs Content --}}
    <div class="tab-content finance-tab-content" id="financeTabContent">
        {{-- Ledger Tab --}}
        <div class="tab-pane fade show active" id="ledger" role="tabpanel">
            @if ($ledger->count() > 0)
                <div class="finance-table-wrapper">
                    <table class="table finance-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.Users.students.finance.table.date') }}</th>
                                <th>{{ trans('admin.Users.students.finance.table.type') }}</th>
                                <th>{{ trans('admin.Users.students.finance.table.description') }}</th>
                                <th class="text-danger">{{ trans('admin.Users.students.finance.table.debit') }}</th>
                                <th class="text-success">{{ trans('admin.Users.students.finance.table.credit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ledger as $entry)
                                <tr class="finance-ledger-row">
                                    <td>
                                        <span class="finance-date">{{ $entry['date'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light-{{ $entry['type_class'] }}">
                                            {{ $entry['type'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="finance-description">{{ $entry['description'] ?? '—' }}</span>
                                    </td>
                                    <td>
                                        @if ($entry['debit'])
                                            <span class="finance-amount debit">{{ $entry['debit'] }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($entry['credit'])
                                            <span class="finance-amount credit">{{ $entry['credit'] }}</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                @include('admin.Users.students.partials.finance_empty_state', [
                    'icon' => 'la-book',
                    'message' => trans('admin.Users.students.finance.empty.ledger'),
                ])
            @endif
        </div>

        {{-- Invoices Tab --}}
        <div class="tab-pane fade" id="invoices" role="tabpanel">
            @if ($invoices->count() > 0)
                <div class="finance-cards-grid">
                    @foreach ($invoices as $invoice)
                        <div class="finance-item-card invoice-card">
                            <div class="finance-item-header">
                                <div class="finance-item-icon bg-danger-soft">
                                    <i class="las la-file-invoice-dollar text-danger"></i>
                                </div>
                                <div class="finance-item-meta">
                                    <span class="finance-item-title">{{ $invoice['fee_title'] }}</span>
                                    <span class="finance-item-date">{{ $invoice['date'] }}</span>
                                </div>
                                <span class="finance-item-amount text-danger">{{ $invoice['amount'] }}</span>
                            </div>
                            <div class="finance-item-body">
                                <div class="finance-item-detail">
                                    <i class="las la-calendar"></i>
                                    <span>{{ $invoice['academic_year'] ?? '—' }}</span>
                                </div>
                                @if ($invoice['description'])
                                    <div class="finance-item-detail">
                                        <i class="las la-info-circle"></i>
                                        <span>{{ $invoice['description'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.Users.students.partials.finance_empty_state', [
                    'icon' => 'la-file-invoice',
                    'message' => trans('admin.Users.students.finance.empty.invoices'),
                ])
            @endif
        </div>

        {{-- Receipts Tab --}}
        <div class="tab-pane fade" id="receipts" role="tabpanel">
            @if ($receipts->count() > 0)
                <div class="finance-cards-grid">
                    @foreach ($receipts as $receipt)
                        <div class="finance-item-card receipt-card">
                            <div class="finance-item-header">
                                <div class="finance-item-icon bg-success-soft">
                                    <i class="las la-receipt text-success"></i>
                                </div>
                                <div class="finance-item-meta">
                                    <span
                                        class="finance-item-title">{{ $receipt['payment_gateway'] ?? trans('admin.Users.students.finance.cash') }}</span>
                                    <span class="finance-item-date">{{ $receipt['date'] }}</span>
                                </div>
                                <span class="finance-item-amount text-success">{{ $receipt['base_amount'] }}</span>
                            </div>
                            <div class="finance-item-body">
                                <div class="finance-item-detail">
                                    <i class="las la-calendar"></i>
                                    <span>{{ $receipt['academic_year'] ?? '—' }}</span>
                                </div>
                                @if ($receipt['currency'] && $receipt['currency'] !== 'USD')
                                    <div class="finance-item-detail">
                                        <i class="las la-coins"></i>
                                        <span>{{ $receipt['paid_amount'] }} {{ $receipt['currency'] }} @
                                            {{ $receipt['exchange_rate'] }}</span>
                                    </div>
                                @endif
                                @if ($receipt['transaction_id'])
                                    <div class="finance-item-detail">
                                        <i class="las la-hashtag"></i>
                                        <span class="text-monospace">{{ $receipt['transaction_id'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.Users.students.partials.finance_empty_state', [
                    'icon' => 'la-receipt',
                    'message' => trans('admin.Users.students.finance.empty.receipts'),
                ])
            @endif
        </div>

        {{-- Discounts Tab --}}
        <div class="tab-pane fade" id="discounts" role="tabpanel">
            @if ($discounts->count() > 0)
                <div class="finance-cards-grid">
                    @foreach ($discounts as $discount)
                        <div class="finance-item-card discount-card">
                            <div class="finance-item-header">
                                <div class="finance-item-icon bg-info-soft">
                                    <i class="las la-percent text-info"></i>
                                </div>
                                <div class="finance-item-meta">
                                    <span class="finance-item-title">{{ $discount['description'] }}</span>
                                    <span class="finance-item-date">{{ $discount['date'] }}</span>
                                </div>
                                <span class="finance-item-amount text-info">{{ $discount['amount'] }}</span>
                            </div>
                            <div class="finance-item-body">
                                <div class="finance-item-detail">
                                    <i class="las la-calendar"></i>
                                    <span>{{ $discount['academic_year'] ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.Users.students.partials.finance_empty_state', [
                    'icon' => 'la-tags',
                    'message' => trans('admin.Users.students.finance.empty.discounts'),
                ])
            @endif
        </div>

        {{-- Vouchers Tab --}}
        @if ($vouchers->count() > 0)
            <div class="tab-pane fade" id="vouchers" role="tabpanel">
                <div class="finance-cards-grid">
                    @foreach ($vouchers as $voucher)
                        <div class="finance-item-card voucher-card">
                            <div class="finance-item-header">
                                <div class="finance-item-icon bg-warning-soft">
                                    <i class="las la-undo text-warning"></i>
                                </div>
                                <div class="finance-item-meta">
                                    <span
                                        class="finance-item-title">{{ $voucher['payment_gateway'] ?? trans('admin.Users.students.finance.cash') }}</span>
                                    <span class="finance-item-date">{{ $voucher['date'] }}</span>
                                </div>
                                <span class="finance-item-amount text-warning">{{ $voucher['base_amount'] }}</span>
                            </div>
                            <div class="finance-item-body">
                                @if ($voucher['reference_number'])
                                    <div class="finance-item-detail">
                                        <i class="las la-hashtag"></i>
                                        <span>{{ $voucher['reference_number'] }}</span>
                                    </div>
                                @endif
                                @if ($voucher['description'])
                                    <div class="finance-item-detail">
                                        <i class="las la-info-circle"></i>
                                        <span>{{ $voucher['description'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal-footer finance-modal-footer border-0">
    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
        <i class="las la-times {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
        {{ trans('admin.global.close') }}
    </button>
</div>
