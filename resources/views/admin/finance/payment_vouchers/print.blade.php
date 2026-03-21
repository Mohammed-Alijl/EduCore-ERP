<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.finance.payment_vouchers.print_title') }} #{{ str_pad($paymentVoucher->id, 6, '0', STR_PAD_LEFT) }}
    </title>
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
            --accent: #dc2626;
            --accent-light: #fee2e2;
            --accent-mid: #ef4444;
            --ink: #0f172a;
            --ink-muted: #475569;
            --ink-subtle: #94a3b8;
            --border: #e2e8f0;
            --surface: #f8fafc;
            --white: #ffffff;
            --paid-red: #dc2626;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f1f5f9;
            color: var(--ink);
            font-size: 13px;
            line-height: 1.6;
            padding: 28px 16px;
        }

        /* -- No-print toolbar -- */
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

        /* -- Voucher card -- */
        .voucher {
            max-width: 780px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(220, 38, 38, .10);
        }

        /* -- Branded header -- */
        .voucher-header {
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
            color: #fecaca;
            margin-top: 3px;
        }

        .voucher-meta {
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
        }

        .voucher-meta .voucher-number {
            font-size: 16px;
            font-weight: 700;
            color: var(--white);
            font-variant-numeric: tabular-nums;
        }

        .voucher-meta .voucher-date {
            font-size: 12px;
            color: #fecaca;
            margin-top: 4px;
        }

        /* -- Stripe -- */
        .stripe {
            height: 4px;
            background: linear-gradient(90deg, #b91c1c, #f87171, #b91c1c);
        }

        /* -- Body -- */
        .voucher-body {
            padding: 24px 28px;
        }

        /* -- Amount hero -- */
        .amount-hero {
            position: relative;
            border: 1.5px solid var(--accent-light);
            border-radius: 12px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            padding: 20px 24px;
            margin-bottom: 24px;
            overflow: hidden;
        }

        .amount-hero::after {
            position: absolute;
            {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left: -14px;' : 'right: -14px;' }} top: 50%;
            transform: translateY(-50%) {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rotate(90deg)' : 'rotate(-90deg)' }};
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .14em;
            color: var(--paid-red);
            background: #fee2e2;
            border: 1.5px solid #fecaca;
            border-radius: 4px;
            padding: 3px 10px;
            white-space: nowrap;
        }

        .amount-hero-paid-stamp {
            position: absolute;
            {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left: -14px;' : 'right: -14px;' }} top: 50%;
            transform: translateY(-50%) {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rotate(90deg)' : 'rotate(-90deg)' }};
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .14em;
            color: var(--paid-red);
            background: #fee2e2;
            border: 1.5px solid #fecaca;
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

        /* -- Info grid -- */
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
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 99px;
            padding: 1px 9px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-ref {
            display: inline-block;
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #d1d5db;
            border-radius: 99px;
            padding: 1px 9px;
            font-size: 11.5px;
            font-weight: 600;
            font-family: monospace;
        }

        /* -- Description -- */
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

        /* -- Footer -- */
        .voucher-footer {
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
            color: var(--paid-red);
            font-weight: 700;
            border: 2px solid var(--paid-red);
            border-radius: 6px;
            padding: 4px 12px;
            opacity: .9;
        }

        /* -- Responsive -- */
        @media (max-width: 620px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .voucher-header {
                flex-direction: column;
                gap: 8px;
            }

            .voucher-meta {
                text-align: unset;
            }
        }

        /* -- Print -- */
        @media print {
            body {
                background: var(--white);
                padding: 0;
            }

            .toolbar {
                display: none;
            }

            .voucher {
                border-radius: 0;
                box-shadow: none;
                max-width: 100%;
            }

            .amount-hero::after {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .voucher-header {
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

    {{-- -- Toolbar (screen only) -- --}}
    <div class="toolbar no-print">
        <a href="{{ url()->previous() }}" class="toolbar-btn btn-back">
            &#8592; {{ trans('admin.global.back') }}
        </a>
        <button type="button" class="toolbar-btn btn-print" onclick="window.print()">
            &#128438; {{ trans('admin.global.print') }}
        </button>
    </div>

    <div class="voucher">

        {{-- -- Header -- --}}
        <div class="voucher-header">
            <div class="brand-block">
                <div class="school-name">{{ config('app.name') }}</div>
                <div class="doc-label">{{ trans('admin.finance.payment_vouchers.print_title') }}</div>
            </div>
            <div class="voucher-meta">
                <div class="voucher-number">
                    PV-#{{ str_pad($paymentVoucher->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <div class="voucher-date">
                    {{ trans('admin.finance.payment_vouchers.fields.date') }}:
                    {{ $paymentVoucher->date->format('d M Y') }}
                </div>
            </div>
        </div>
        <div class="stripe"></div>

        {{-- -- Body -- --}}
        <div class="voucher-body">

            {{-- Amount hero --}}
            <div class="amount-hero">
                <div class="amount-hero-paid-stamp">{{ trans('admin.finance.payment_vouchers.print_paid_stamp') }}</div>
                <div class="amount-label">{{ trans('admin.finance.payment_vouchers.fields.amount') }}</div>
                <div class="amount-value">
                    {{ number_format($paymentVoucher->amount, 2) }}
                    <span
                        style="font-size:22px; font-weight:700; color:#dc2626;">{{ $paymentVoucher->currency_code }}</span>
                </div>
                <div class="amount-sub">
                    @if ($paymentVoucher->base_amount != $paymentVoucher->amount)
                        <span class="amount-sub-item">
                            {{ trans('admin.finance.payment_vouchers.fields.base_amount') }}:
                            <strong>${{ number_format($paymentVoucher->base_amount, 2) }}</strong>
                        </span>
                        <span class="amount-sub-item">
                            {{ trans('admin.finance.payment_vouchers.print_exchange_rate') }}:
                            <strong>1 {{ $paymentVoucher->currency_code }} =
                                {{ number_format($paymentVoucher->exchange_rate, 4) }}</strong>
                        </span>
                    @endif
                    <span class="amount-sub-item">
                        {{ trans('admin.finance.payment_vouchers.fields.academic_year') }}:
                        <strong>{{ $paymentVoucher->academicYear->name ?? '-' }}</strong>
                    </span>
                </div>
            </div>

            {{-- Info grid --}}
            <div class="info-grid">

                {{-- Student card --}}
                <div class="info-card">
                    <div class="info-card-header">{{ trans('admin.finance.payment_vouchers.fields.student') }}</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.global.name') }}</span>
                            <span class="info-val">{{ $paymentVoucher->student->name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.global.code') }}</span>
                            <span class="info-val">{{ $paymentVoucher->student->student_code ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.students.fields.grade') }}</span>
                            <span class="info-val">{{ $paymentVoucher->student->grade->name ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.students.fields.classroom') }}</span>
                            <span class="info-val">{{ $paymentVoucher->student->classroom->name ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Voucher details card --}}
                <div class="info-card">
                    <div class="info-card-header">{{ trans('admin.finance.payment_vouchers.print_voucher_details') }}</div>
                    <div class="info-card-body">
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.finance.payment_vouchers.print_voucher_no') }}</span>
                            <span class="info-val">PV-#{{ str_pad($paymentVoucher->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-key">{{ trans('admin.finance.payment_vouchers.fields.payment_gateway') }}</span>
                            <span class="info-val">
                                <span class="badge-gateway">{{ $paymentVoucher->paymentGateway->name ?? '-' }}</span>
                            </span>
                        </div>
                        @if ($paymentVoucher->reference_number)
                            <div class="info-row">
                                <span
                                    class="info-key">{{ trans('admin.finance.payment_vouchers.fields.reference_number') }}</span>
                                <span class="info-val">
                                    <span class="badge-ref">{{ $paymentVoucher->reference_number }}</span>
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
            @if ($paymentVoucher->description)
                <div class="notes-section">
                    <div class="notes-header">{{ trans('admin.finance.payment_vouchers.fields.description') }}</div>
                    <div class="notes-body">{{ $paymentVoucher->description }}</div>
                </div>
            @endif

        </div>{{-- /voucher-body --}}

        {{-- -- Footer -- --}}
        <div class="voucher-footer">
            <div class="footer-left">
                <strong>{{ config('app.name') }}</strong>
                {{ trans('admin.finance.payment_vouchers.print_footer_note') }}
            </div>
            <div class="footer-right">
                <div class="official-stamp">&#10003; {{ trans('admin.finance.payment_vouchers.print_official') }}</div>
            </div>
        </div>

    </div>{{-- /voucher --}}


</body>

</html>
