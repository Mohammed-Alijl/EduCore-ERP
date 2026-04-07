<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.Finance.receipts.print_title') }} #{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --accent: #0f766e;
            --accent-light: #ccfbf1;
            --accent-mid: #14b8a6;
            --ink: #0f172a;
            --ink-muted: #475569;
            --ink-subtle: #94a3b8;
            --border: #e2e8f0;
            --surface: #f8fafc;
            --white: #ffffff;
            --paid-green: #16a34a;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f1f5f9;
            color: var(--ink);
            font-size: 13px;
            line-height: 1.6;
            padding: 28px 16px;
        }

        /* ── No-print toolbar ───────────────────────────── */
        .toolbar {
            max-width: 780px;
            margin: 0 auto 14px;
            display: flex;
            justify-content: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'flex-start' : 'flex-end' }};
            gap: 8px;
        }

        .toolbar-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 0;
            border-radius: 7px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-print {
            background: var(--accent);
            color: var(--white);
        }

        .btn-back {
            background: var(--white);
            color: var(--ink-muted);
            border: 1px solid var(--border);
        }

        /* ── Receipt card ───────────────────────────────── */
        .receipt {
            max-width: 780px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(15, 118, 110, .10);
        }

        /* ── Branded header ─────────────────────────────── */
        .receipt-header {
            background: var(--accent);
            padding: 22px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .brand-block .school-name {
            font-size: 20px;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -.4px;
            line-height: 1.2;
        }

        .brand-block .doc-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #99f6e4;
            margin-top: 3px;
        }

        .receipt-meta {
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
        }

        .receipt-meta .receipt-number {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            font-variant-numeric: tabular-nums;
        }

        .receipt-meta .receipt-date {
            font-size: 12px;
            color: #ccfbf1;
            margin-top: 4px;
        }

        /* ── Stripe ─────────────────────────────────────── */
        .stripe {
            height: 4px;
            background: linear-gradient(90deg, #0d9488, #5eead4, #0d9488);
        }

        /* ── Body ───────────────────────────────────────── */
        .receipt-body {
            padding: 24px 28px;
        }

        /* ── Amount hero ────────────────────────────────── */
        .amount-hero {
            position: relative;
            border: 1.5px solid var(--accent-light);
            border-radius: 12px;
            background: linear-gradient(135deg, #f0fdf9 0%, #ccfbf1 100%);
            padding: 20px 24px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .amount-hero::after {
            content: '✓ PAID';
            position: absolute;
            {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left: -14px;' : 'right: -14px;' }} top: 50%;
            transform: translateY(-50%) {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rotate(90deg)' : 'rotate(-90deg)' }};
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .14em;
            color: var(--paid-green);
            background: #dcfce7;
            border: 1.5px solid #bbf7d0;
            border-radius: 4px;
            padding: 3px 10px;
            white-space: nowrap;
        }

        .amount-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--accent);
            margin-bottom: 4px;
        }

        .amount-value {
            font-size: 36px;
            font-weight: 800;
            color: var(--ink);
            letter-spacing: -1px;
            line-height: 1.1;
            font-variant-numeric: tabular-nums;
        }

        .amount-sub {
            margin-top: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .amount-sub-item {
            font-size: 12px;
            color: var(--ink-muted);
        }

        .amount-sub-item strong {
            color: var(--ink);
        }

        /* ── Info grid ──────────────────────────────────── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-card {
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .info-card-header {
            background: var(--surface);
            padding: 8px 14px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--accent);
            border-bottom: 1px solid var(--border);
        }

        .info-card-body {
            padding: 12px 14px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
            padding: 5px 0;
            border-bottom: 1px dashed var(--border);
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-row:first-child {
            padding-top: 0;
        }

        .info-key {
            font-size: 11.5px;
            color: var(--ink-muted);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .info-val {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink);
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
            word-break: break-word;
        }

        /* Badges */
        .badge-gateway {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            border-radius: 99px;
            padding: 1px 9px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-txn {
            display: inline-block;
            background: #fefce8;
            color: #854d0e;
            border: 1px solid #fef08a;
            border-radius: 99px;
            padding: 1px 9px;
            font-size: 11.5px;
            font-weight: 600;
            font-family: monospace;
        }

        /* ── Description ────────────────────────────────── */
        .notes-section {
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .notes-header {
            background: var(--surface);
            padding: 8px 14px;
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--ink-muted);
            border-bottom: 1px solid var(--border);
        }

        .notes-body {
            padding: 12px 14px;
            font-size: 12.5px;
            color: var(--ink-muted);
            min-height: 52px;
            white-space: pre-wrap;
        }

        /* ── Footer ─────────────────────────────────────── */
        .receipt-footer {
            border-top: 1px solid var(--border);
            background: var(--surface);
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .footer-left {
            font-size: 11px;
            color: var(--ink-subtle);
            line-height: 1.8;
        }

        .footer-left strong {
            display: block;
            font-size: 12px;
            color: var(--ink-muted);
        }

        .footer-right {
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
        }

        .official-stamp {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: var(--paid-green);
            font-weight: 700;
            border: 2px solid var(--paid-green);
            border-radius: 6px;
            padding: 4px 12px;
            opacity: .9;
        }

        /* ── Responsive ─────────────────────────────────── */
        @media (max-width: 620px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .receipt-header {
                flex-direction: column;
                gap: 8px;
            }

            .receipt-meta {
                text-align: unset;
            }
        }

        /* ── Print ──────────────────────────────────────── */
        @media print {
            body {
                background: var(--white);
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .receipt {
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }

            .amount-hero::after {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .receipt-header {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .stripe {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    {{-- ── Toolbar (screen only) ───────────────────────── --}}
    <div class="toolbar no-print">
        <a href="{{ url()->previous() }}" class="toolbar-btn btn-back">
            &#8592; {{ trans('admin.global.back') }}
        </a>
        <button type="button" class="toolbar-btn btn-print" onclick="window.print()">
            &#128438; {{ trans('admin.global.print') }}
        </button>
    </div>

    <div class="receipt">

        {{-- ── Header ──────────────────────────────────── --}}
        <div class="receipt-header">
            <div class="brand-block">
                <div class="school-name">{{ config('app.name') }}</div>
                <div class="doc-label">{{ trans('admin.Finance.receipts.print_title') }}</div>
            </div>
            <div class="receipt-meta">
                <div class="receipt-number">
                    RCP-#{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div class="receipt-date">
                    {{ trans('admin.Finance.receipts.fields.date') }}:
                    {{ $receipt->date->format('d M Y') }}
                </div>
            </div>
        </div>
        <div class="stripe"></div>

        {{-- ── Body ───────────────────────────────────── --}}
        <div class="receipt-body">

            {{-- Amount hero --}}
            <div class="amount-hero">
                <div class="amount-label">{{ trans('admin.Finance.receipts.fields.paid_amount') }}</div>
                <div class="amount-value">
                    {{ number_format($receipt->paid_amount, 2) }}
                    <span style="font-size:22px; font-weight:700; color:#0f766e;">{{ $receipt->currency_code }}</span>
                </div>
                <div class="amount-sub">
                    @if ($receipt->currency && !$receipt->currency->is_default)
                        <span class="amount-sub-item">
                            {{ trans('admin.Finance.receipts.fields.base_amount') }}:
                            <strong>{{ number_format($receipt->base_amount, 2) }}</strong>
                        </span>
                        <span class="amount-sub-item">
                            {{ trans('admin.Finance.receipts.print_exchange_rate') }}:
                            <strong>1 {{ $receipt->currency_code }} =
                                {{ number_format($receipt->exchange_rate, 4) }}</strong>
                        </span>
                    @endif
                    <span class="amount-sub-item">
                        {{ trans('admin.Finance.receipts.fields.academic_year') }}:
                        <strong>{{ $receipt->academicYear->name ?? '—' }}</strong>
                    </span>
                </div>
            </div>

            {{-- Info grid --}}
            <div class="info-grid">

                {{-- Student card --}}
                <div class="info-card">
                    <div class="info-card-header">{{ trans('admin.Finance.receipts.fields.student') }}</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.global.name') }}</span>
                            <span class="info-val">{{ $receipt->student->name ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.global.code') }}</span>
                            <span class="info-val">{{ $receipt->student->student_code ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.Users.students.fields.grade') }}</span>
                            <span class="info-val">{{ $receipt->student->grade->name ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.Users.students.fields.classroom') }}</span>
                            <span class="info-val">{{ $receipt->student->classroom->name ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Receipt details card --}}
                <div class="info-card">
                    <div class="info-card-header">{{ trans('admin.Finance.receipts.print_receipt_details') }}</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.Finance.receipts.print_receipt_no') }}</span>
                            <span class="info-val">RCP-#{{ str_pad($receipt->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.Finance.receipts.fields.payment_gateway') }}</span>
                            <span class="info-val">
                                <span class="badge-gateway">{{ $receipt->paymentGateway->name ?? '—' }}</span>
                            </span>
                        </div>
                        @if ($receipt->transaction_id)
                            <div class="info-row">
                                <span
                                    class="info-key">{{ trans('admin.Finance.receipts.fields.transaction_id') }}</span>
                                <span class="info-val">
                                    <span class="badge-txn">{{ $receipt->transaction_id }}</span>
                                </span>
                            </div>
                        @endif
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.global.print_date') }}</span>
                            <span class="info-val">{{ now()->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

            </div>{{-- /info-grid --}}

            {{-- Notes --}}
            @if ($receipt->description)
                <div class="notes-section">
                    <div class="notes-header">{{ trans('admin.Finance.receipts.fields.description') }}</div>
                    <div class="notes-body">{{ $receipt->description }}</div>
                </div>
            @endif

        </div>{{-- /receipt-body --}}

        {{-- ── Footer ──────────────────────────────────── --}}
        <div class="receipt-footer">
            <div class="footer-left">
                <strong>{{ config('app.name') }}</strong>
                {{ trans('admin.Finance.receipts.print_footer_note') }}
            </div>
            <div class="footer-right">
                <div class="official-stamp">&#10003; {{ trans('admin.Finance.receipts.print_official') }}</div>
            </div>
        </div>

    </div>{{-- /receipt --}}


</body>

</html>
