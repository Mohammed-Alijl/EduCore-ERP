<?php

namespace App\Exports;

use App\Services\Reports\FinancialReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class FinancialExport implements FromCollection, ShouldAutoSize, ShouldQueue, WithChunkReading, WithColumnFormatting, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use Exportable;

    private int $currentRow = 2;

    public function __construct(
        protected FinancialReportService $service
    ) {}

    public function collection()
    {
        // getOutstandingBalancesQuery returns a Collection in the FinancialReportService
        return $this->service->getOutstandingBalancesQuery();
    }

    public function headings(): array
    {
        return [
            trans('admin.exports.financial_report.student_name'),
            trans('admin.exports.financial_report.total_charges'),
            trans('admin.exports.financial_report.total_payments'),
            trans('admin.exports.financial_report.net_balance'),
            trans('admin.exports.financial_report.last_payment_date'),
        ];
    }

    public function map($result): array
    {
        $lastPaymentDate = $result->last_payment_date ? Carbon::parse($result->last_payment_date)->format('Y-m-d') : trans('admin.exports.financial_report.no_payment');

        $row = [
            $result->name,
            number_format($result->total_charges, 2),
            number_format($result->total_payments, 2),
            number_format($result->net_balance, 2),
            $lastPaymentDate,
        ];

        $this->currentRow++;

        return $row;
    }

    public function columnFormats(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
            // Set row height for header
            'A1:E1' => [
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return trans('admin.exports.financial_report.sheet_title');
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
