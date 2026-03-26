<?php

namespace App\Exports;

use App\Services\Reports\GradesReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
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

class GradesExport implements FromQuery, ShouldAutoSize, ShouldQueue, WithChunkReading, WithColumnFormatting, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use Exportable;

    private int $currentRow = 2;

    public function __construct(
        protected GradesReportService $service,
        protected array $filters
    ) {}

    public function query(): Builder
    {
        return $this->service->buildGradesQuery($this->filters);
    }

    public function headings(): array
    {
        return [
            trans('admin.exports.grades_report.student_name'),
            trans('admin.exports.grades_report.grade'),
            trans('admin.exports.grades_report.classroom'),
            trans('admin.exports.grades_report.section'),
            trans('admin.exports.grades_report.subject'),
            trans('admin.exports.grades_report.exam'),
            trans('admin.exports.grades_report.score'),
            trans('admin.exports.grades_report.total_marks'),
            trans('admin.exports.grades_report.percentage'),
        ];
    }

    public function map($result): array
    {
        $formula = "=IF(H{$this->currentRow}=0,0,(G{$this->currentRow}/H{$this->currentRow})*100)";

        $row = [
            $result->student_name,
            $result->grade_name,
            $result->classroom_name,
            $result->section_name ?? '-',
            $result->subject_name,
            $result->exam_title,
            $result->final_score,
            $result->total_marks,
            $formula,
        ];

        $this->currentRow++;

        return $row;
    }

    public function columnFormats(): array
    {
        return [
            'I' => '0.00"%"',  // Percentage column
        ];
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
            'A1:I1' => [
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
        ];
    }

    public function title(): string
    {
        return trans('admin.exports.grades_report.sheet_title');
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
