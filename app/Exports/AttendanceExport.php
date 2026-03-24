<?php

namespace App\Exports;

use App\Services\Reports\AttendanceReportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, ShouldAutoSize, ShouldQueue, WithChunkReading, WithHeadings, WithMapping, WithStyles, WithTitle
{
    use Exportable;

    private const CHUNK_SIZE = 1000;

    /**
     * Create a new export instance.
     */
    public function __construct(
        private readonly int $academicYearId,
        private readonly ?int $gradeId = null,
        private readonly ?int $sectionId = null
    ) {}

    /**
     * Returns a query builder that will be used to fetch the data for the export.
     */
    public function query()
    {
        $service = app(AttendanceReportService::class);

        return $service->getExportQuery(
            $this->academicYearId,
            $this->gradeId,
            $this->sectionId
        );
    }

    /**
     * Define the chunk size for reading the export data.
     */
    public function chunkSize(): int
    {
        return self::CHUNK_SIZE;
    }

    /**
     * Define the worksheet title.
     */
    public function title(): string
    {
        return trans('admin.exports.attendance_report.sheet_title');
    }

    /**
     * Defines the column headings for the Excel export.
     *
     * @return array<string>
     */
    public function headings(): array
    {
        return [
            trans('admin.exports.attendance_report.student_code'),
            trans('admin.exports.attendance_report.student_name'),
            trans('admin.exports.attendance_report.section'),
            trans('admin.exports.attendance_report.total_days'),
            trans('admin.exports.attendance_report.present_days'),
            trans('admin.exports.attendance_report.absent_days'),
            trans('admin.exports.attendance_report.late_days'),
            trans('admin.exports.attendance_report.attendance_percentage'),
        ];
    }

    /**
     * Maps each student record to an array that represents a row in the Excel file.
     *
     * @param  object  $student
     * @return array<mixed>
     */
    public function map($student): array
    {
        return [
            $student->student_code,
            $student->student_name,
            $student->total_days,
            $student->present_days,
            $student->absent_days,
            $student->late_days,
            $student->attendance_percentage.'%',
        ];
    }

    /**
     * Apply styles to the worksheet.
     */
    public function styles(Worksheet $sheet): array
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // All cells border
            "A1:{$lastColumn}{$lastRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Center numeric columns (D to H)
            "D2:H{$lastRow}" => [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
