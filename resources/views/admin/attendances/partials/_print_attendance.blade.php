<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}"
    dir="{{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans('admin.attendances.print_title') ?? 'Attendance Report' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .print-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
        }

        .print-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .print-header p {
            margin: 5px 0;
            font-size: 12px;
        }

        .print-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
            flex-wrap: wrap;
        }

        .print-info-item {
            flex: 1;
            min-width: 200px;
            margin-bottom: 10px;
        }

        .print-info-label {
            font-weight: bold;
            color: #555;
        }

        .print-info-value {
            color: #333;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f4f4f4;
            border: 1px solid #999;
            padding: 12px;
            text-align: {{ LaravelLocalization::getCurrentLocale() === 'ar' ? 'right' : 'left' }};
            font-weight: bold;
            font-size: 13px;
        }

        td {
            border: 1px solid #999;
            padding: 10px 12px;
            font-size: 12px;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f0f0f0;
        }

        .status-present {
            color: #28a745;
            font-weight: bold;
        }

        .status-absent {
            color: #dc3545;
            font-weight: bold;
        }

        .status-late {
            color: #ffc107;
            font-weight: bold;
        }

        .status-excused {
            color: #17a2b8;
            font-weight: bold;
        }

        .print-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .student-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            color: #333;
            flex-shrink: 0;
        }

        .student-details {
            display: flex;
            flex-direction: column;
        }

        .student-name {
            font-weight: bold;
            color: #333;
        }

        .student-id {
            font-size: 11px;
            color: #666;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none;
            }

            table {
                page-break-inside: avoid;
            }

            tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="print-header">
        <h1>{{ config('app.name') }}</h1>
        <p>{{ trans('admin.attendances.print_title') ?? 'Attendance Report' }}</p>
    </div>

    <div class="print-info">
        <div class="print-info-item">
            <div class="print-info-label">{{ trans('admin.attendances.attendance_date') }}:</div>
            <div class="print-info-value">{{ request('attendance_date') }}</div>
        </div>
        <div class="print-info-item">
            <div class="print-info-label">{{ trans('admin.attendances.total_students') ?? 'Total Students' }}:</div>
            <div class="print-info-value">{{ $students->count() }}</div>
        </div>
        <div class="print-info-item">
            <div class="print-info-label">{{ trans('admin.global.print_date') ?? 'Print Date' }}:</div>
            <div class="print-info-value">{{ now()->format('Y-m-d H:i:s') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">#</th>
                <th style="min-width: 200px;">{{ trans('admin.attendances.student_details') }}</th>
                <th style="min-width: 150px;">{{ trans('admin.attendances.attendance_status') }}</th>
                <th style="width: 100px;">{{ trans('admin.global.notes') ?? 'Notes' }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php
                    $currentStatus = (int) optional($student->attendances->first())->attendance_status;
                    if (!$currentStatus) {
                        $currentStatus = 1;
                    }

                    $statusLabels = [
                        1 => trans('admin.attendances.present'),
                        2 => trans('admin.attendances.absent'),
                        3 => trans('admin.attendances.late'),
                        4 => trans('admin.attendances.excused'),
                    ];

                    $statusClasses = [
                        1 => 'status-present',
                        2 => 'status-absent',
                        3 => 'status-late',
                        4 => 'status-excused',
                    ];

                    $statusLabel = $statusLabels[$currentStatus] ?? trans('admin.attendances.present');
                    $statusClass = $statusClasses[$currentStatus] ?? 'status-present';
                @endphp

                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>
                        <div class="student-info">
                            @if ($student->image)
                                <img src="{{ asset('storage/' . $student->image) }}" alt="{{ $student->name }}"
                                    class="student-avatar" style="width: 40px; height: 40px; border-radius: 50%;">
                            @else
                                <div class="student-avatar">
                                    {{ mb_substr($student->name ?? 'S', 0, 1) }}
                                </div>
                            @endif
                            <div class="student-details">
                                <span class="student-name">{{ $student->name }}</span>
                                <span class="student-id">ID: {{ $student->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <span class="text-uppercase font-weight-bold {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        {{ optional($student->attendances->first())->notes ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 30px;">
                        {{ trans('admin.attendances.no_students') ?? 'No students found' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="print-footer">
        <p>{{ trans('admin.attendances.print_footer') ?? 'This is an automatically generated report' }}</p>
        <p style="margin-top: 10px;">{{ config('app.name') }} - {{ now()->year }}</p>
    </div>
</body>

</html>
