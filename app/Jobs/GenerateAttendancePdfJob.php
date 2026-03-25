<?php

namespace App\Jobs;

use App\Models\Admin;
use App\Notifications\ExportFailedNotification;
use App\Notifications\ExportReadyNotification;
use App\Services\Exports\ExportService;
use App\Services\Reports\AttendanceReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateAttendancePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job should run.
     */
    public int $timeout = 600;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    private const EXPORT_TYPE = 'attendance_report_pdf';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Admin $admin,
        private readonly int $academicYearId,
        private readonly ?int $gradeId = null,
        private readonly ?int $sectionId = null,
        private readonly string $locale = 'ar'
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService, AttendanceReportService $reportService): void
    {
        $fileName = $exportService->generateFileName('attendance_report', 'pdf');
        $filePath = $exportService->getFilePath($fileName);
        $fullPath = Storage::disk($exportService->getDisk())->path($filePath);

        try {
            $this->ensureExportDirectoryExists($exportService);

            $data = $reportService->getExportQuery(
                $this->academicYearId,
                $this->gradeId,
                $this->sectionId,
                $this->locale
            )->get();

            $chartData = $reportService->getChartDataForPdf(
                $this->academicYearId,
                $this->locale
            );

            $html = $this->renderPdfView($data, $chartData);

            $this->generatePdf($html, $fullPath);

            $this->admin->notify(
                new ExportReadyNotification($fileName, self::EXPORT_TYPE)
            );

            Log::info('Attendance PDF export generated successfully', [
                'admin_id' => $this->admin->id,
                'file_name' => $fileName,
                'academic_year_id' => $this->academicYearId,
                'grade_id' => $this->gradeId,
                'section_id' => $this->sectionId,
                'records_count' => $data->count(),
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to generate attendance PDF export', [
                'admin_id' => $this->admin->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'academic_year_id' => $this->academicYearId,
            ]);

            throw $e;
        }
    }

    /**
     * Ensure the export directory exists.
     */
    private function ensureExportDirectoryExists(ExportService $exportService): void
    {
        $disk = Storage::disk($exportService->getDisk());
        $basePath = $exportService->getBasePath();

        if (! $disk->exists($basePath)) {
            $disk->makeDirectory($basePath);
        }
    }

    /**
     * Render the PDF blade view to HTML string.
     *
     * @param  \Illuminate\Support\Collection  $data
     */
    private function renderPdfView($data, array $chartData): string
    {
        return view('admin.reports.attendance.pdf_view', [
            'records' => $data,
            'chartData' => $chartData,
            'generatedAt' => now(),
            'academicYearId' => $this->academicYearId,
            'gradeId' => $this->gradeId,
            'sectionId' => $this->sectionId,
            'locale' => $this->locale,
        ])->render();
    }

    /**
     * Generate PDF using Browsershot.
     */
    private function generatePdf(string $html, string $outputPath): void
    {
        Browsershot::html($html)
            ->setChromePath('/usr/bin/google-chrome')
            ->format('A4')
            ->margins(15, 10, 15, 10)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->setDelay(2000)
            ->noSandbox()
            ->setOption('args', ['--disable-web-security'])
            ->save($outputPath);
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        $this->admin->notify(
            new ExportFailedNotification(
                self::EXPORT_TYPE,
                $exception?->getMessage() ?? 'Unknown error'
            )
        );

        Log::error('Attendance PDF export job failed after all retries', [
            'admin_id' => $this->admin->id,
            'error' => $exception?->getMessage(),
            'academic_year_id' => $this->academicYearId,
        ]);
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return [
            'export',
            'pdf',
            'attendance',
            'admin:'.$this->admin->id,
        ];
    }
}
