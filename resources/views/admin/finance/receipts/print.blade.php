<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.finance.receipts.title') }} #{{ $receipt->receipt_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.5;
            padding: 24px;
        }

        .receipt-wrapper {
            max-width: 860px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        /* ── Header ────────────────────────────────── */
        .receipt-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            padding: 28px 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand h1 {
            font-size: 22px;
            color: #ffffff;
            margin-bottom: 4px;
        }

        .brand p {
            color: rgba(255,255,255,.75);
            font-size: 13px;
        }

        .receipt-meta {
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
        }

        .receipt-meta .receipt-number {
            font-size: 1.2rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .receipt-meta p {
            color: rgba(255,255,255,.75);
            font-size: 13px;
        }

        /* ── Paid Stamp ────────────────────────────── */
        .paid-stamp {
            display: inline-block;
            border: 3px solid #10b981;
            border-radius: 8px;
            padding: 4px 14px;
            color: #065f46;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            transform: rotate(-8deg);
            background: #ecfdf5;
        }

        /* ── Body ──────────────────────────────────── */
        .receipt-body {
            padding: 28px 32px;
        }

        .section-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #059669;
            margin-bottom: 10px;
            letter-spacing: .08em;
            font-weight: 700;
            border-bottom: 2px solid #d1fae5;
            padding-bottom: 6px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
            background: #fafffe;
        }

        .field {
            margin-bottom: 8px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .field-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6b7280;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .field-value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
        }

        /* ── Amount Card ───────────────────────────── */
        .amount-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 2px solid #6ee7b7;
            border-radius: 12px;
            padding: 20px 24px;
            text-align: center;
            margin-bottom: 22px;
        }

        .amount-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #065f46;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .amount-value {
            font-size: 2.4rem;
            font-weight: 800;
            color: #047857;
            letter-spacing: -1px;
            line-height: 1;
        }

        .amount-currency {
            font-size: 0.9rem;
            color: #065f46;
            margin-top: 4px;
        }

        /* ── Payment Badge ─────────────────────────── */
        .payment-badge {
            display: inline-block;
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        /* ── Footer ────────────────────────────────── */
        .receipt-footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .receipt-footer small {
            color: #9ca3af;
            font-size: 11px;
        }

        /* ── Print Button ──────────────────────────── */
        .print-btn {
            display: inline-block;
            margin: 16px auto;
            padding: 10px 28px;
            background: #10b981;
            color: #fff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-align: center;
        }

        .print-actions {
            text-align: center;
            margin-bottom: 16px;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt-wrapper { border: none; border-radius: 0; }
            .print-actions { display: none; }
        }
    </style>
</head>

<body>
    <div class="print-actions">
        <button class="print-btn" onclick="window.print()">
            🖨️ {{ trans('admin.global.print') }}
        </button>
    </div>

    <div class="receipt-wrapper">

        <!-- ── HEADER ───────────────────────────────────── -->
        <div class="receipt-header">
            <div class="brand">
                <h1>{{ config('app.name', 'EduCore ERP') }}</h1>
                <p>{{ trans('admin.finance.receipts.title') }}</p>
                <p>{{ now()->format('d M Y') }}</p>
            </div>
            <div class="receipt-meta">
                <div class="receipt-number">{{ $receipt->receipt_number }}</div>
                <p><strong>INV-#{{ $receipt->invoice_id }}</strong></p>
                <p>{{ $receipt->receipt_date->format('d M Y') }}</p>
                <br>
                <div class="paid-stamp">✓ PAID</div>
            </div>
        </div>

        <!-- ── BODY ─────────────────────────────────────── -->
        <div class="receipt-body">

            <!-- Amount -->
            <div class="amount-card">
                <div class="amount-label">{{ trans('admin.finance.receipts.fields.amount') }}</div>
                <div class="amount-value">${{ number_format($receipt->amount, 2) }}</div>
                <div class="amount-currency">{{ trans('admin.finance.receipts.currency') }}</div>
                <div style="margin-top:10px;">
                    <span class="payment-badge">
                        {{ trans('admin.finance.receipts.payment_methods.' . $receipt->payment_method) }}
                    </span>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid">

                <!-- Student Info -->
                <div class="card">
                    <div class="section-title">{{ trans('admin.finance.receipts.fields.student') }}</div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.global.name') }}</div>
                        <div class="field-value">{{ $receipt->student->name ?? '—' }}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.global.code') }}</div>
                        <div class="field-value">{{ $receipt->student->student_code ?? '—' }}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.finance.receipts.fields.academic_year') }}</div>
                        <div class="field-value">{{ $receipt->academicYear->name ?? '—' }}</div>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="card">
                    <div class="section-title">{{ trans('admin.finance.receipts.fields.payment_method') }}</div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.finance.receipts.fields.payment_method') }}</div>
                        <div class="field-value">
                            {{ trans('admin.finance.receipts.payment_methods.' . $receipt->payment_method) }}
                        </div>
                    </div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.finance.receipts.fields.date') }}</div>
                        <div class="field-value">{{ $receipt->receipt_date->format('d M Y') }}</div>
                    </div>
                    <div class="field">
                        <div class="field-label">{{ trans('admin.finance.receipts.fields.invoice') }}</div>
                        <div class="field-value">INV-#{{ $receipt->invoice_id }}</div>
                    </div>
                </div>

            </div>

            @if ($receipt->description)
                <div class="card" style="margin-bottom: 0;">
                    <div class="section-title">{{ trans('admin.finance.receipts.fields.description') }}</div>
                    <div class="field">
                        <div class="field-value">{{ $receipt->description }}</div>
                    </div>
                </div>
            @endif

        </div>

        <!-- ── FOOTER ───────────────────────────────────── -->
        <div class="receipt-footer">
            <small>{{ trans('admin.footer.copyright') }} {{ now()->year }} {{ config('app.name') }}</small>
            <small>{{ trans('admin.finance.receipts.title') }} • {{ $receipt->receipt_number }}</small>
        </div>

    </div>
</body>
</html>
