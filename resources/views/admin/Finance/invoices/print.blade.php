<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.Finance.invoices.title') }} #{{ $invoice->id }}</title>
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

        .invoice-wrapper {
            max-width: 920px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .invoice-header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .brand h1 {
            font-size: 22px;
            color: #111827;
            margin-bottom: 6px;
        }

        .brand p,
        .meta p {
            color: #4b5563;
            font-size: 13px;
        }

        .meta {
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'left' : 'right' }};
        }

        .meta .invoice-number {
            font-size: 18px;
            color: #111827;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .invoice-body {
            padding: 24px;
        }

        .section-title {
            font-size: 13px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 10px;
            letter-spacing: .06em;
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            background: #fff;
        }

        .field {
            margin-bottom: 8px;
        }

        .field:last-child {
            margin-bottom: 0;
        }

        .label {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .value {
            font-size: 14px;
            color: #111827;
            font-weight: 600;
            word-break: break-word;
        }

        .amount-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 22px;
            background: #f9fafb;
            text-align: center;
        }

        .amount-box .amount-label {
            display: block;
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 6px;
            letter-spacing: .06em;
            font-weight: 700;
        }

        .amount-box .amount-value {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
        }

        .description {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 14px;
            background: #fff;
            color: #1f2937;
            min-height: 72px;
            white-space: pre-wrap;
        }

        .invoice-footer {
            border-top: 1px solid #e5e7eb;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            color: #6b7280;
            font-size: 12px;
            flex-wrap: wrap;
        }

        .no-print {
            max-width: 920px;
            margin: 0 auto 14px;
            display: flex;
            justify-content: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'flex-start' : 'flex-end' }};
        }

        .print-btn {
            border: 0;
            background: #111827;
            color: #fff;
            font-size: 13px;
            border-radius: 6px;
            padding: 10px 16px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .meta {
                text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'right' : 'left' }};
            }
        }

        @media print {
            body {
                padding: 0;
                background: #fff;
            }

            .invoice-wrapper {
                border: none;
                border-radius: 0;
                max-width: 100%;
            }

            .no-print {
                display: none;
            }

            .invoice-footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="no-print">
        <button type="button" class="print-btn" onclick="window.print()">{{ trans('admin.global.print') }}</button>
    </div>

    <div class="invoice-wrapper">
        <div class="invoice-header">
            <div class="brand">
                <h1>{{ config('app.name') }}</h1>
                <p>{{ trans('admin.Finance.invoices.show') }}</p>
            </div>
            <div class="meta">
                <div class="invoice-number">INV-#{{ $invoice->id }}</div>
                <p>{{ trans('admin.Finance.invoices.fields.date') }}:
                    {{ optional($invoice->invoice_date)->format('Y-m-d') }}</p>
                <p>{{ trans('admin.global.print_date') ?? 'Print Date' }}: {{ now()->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <div class="invoice-body">
            <div class="amount-box">
                <span class="amount-label">{{ trans('admin.Finance.invoices.fields.amount') }}</span>
                <div class="amount-value">{{ number_format($invoice->amount, 2) }}
                    {{ trans('admin.Finance.invoices.currency') }}</div>
            </div>

            <div class="grid">
                <div>
                    <div class="section-title">{{ trans('admin.Finance.invoices.fields.student') }}</div>
                    <div class="card">
                        <div class="field">
                            <span class="label">{{ trans('admin.global.name') }}</span>
                            <span class="value">{{ $invoice->student->name ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <span class="label">{{ trans('admin.global.code') }}</span>
                            <span class="value">{{ $invoice->student->student_code ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <span class="label">{{ trans('admin.Users.students.fields.grade') }}</span>
                            <span class="value">{{ $invoice->grade->name ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <span class="label">{{ trans('admin.Users.students.fields.classroom') }}</span>
                            <span class="value">{{ $invoice->classroom->name ?? '—' }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="section-title">{{ trans('admin.Finance.invoices.fields.fee_details') }}</div>
                    <div class="card">
                        <div class="field">
                            <span class="label">{{ trans('admin.Finance.fees.fields.title') }}</span>
                            <span class="value">{{ $invoice->fee->title ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <span class="label">{{ trans('admin.Finance.fees.fields.category') }}</span>
                            <span class="value">{{ $invoice->fee->feeCategory->title ?? '—' }}</span>
                        </div>
                        <div class="field">
                            <span class="label">{{ trans('admin.Finance.invoices.fields.academic_year') }}</span>
                            <span class="value">{{ $invoice->academicYear->name ?? '—' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-title">{{ trans('admin.Finance.invoices.fields.description') }}</div>
            <div class="description">{{ $invoice->description ?: trans('admin.global.no_description') }}</div>
        </div>

        <div class="invoice-footer">
            <span>{{ trans('admin.Finance.invoices.title') }}</span>
            <span>{{ config('app.name') }}</span>
        </div>
    </div>
</body>

</html>
