<?php

namespace App\Jobs;

use App\Models\Users\Admin;
use App\Notifications\ExportFailedNotification;
use App\Notifications\ExportReadyNotification;
use App\Services\Exports\ExportService;
use App\Services\Reports\GradesReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Throwable;

class GenerateGradesPdfJob implements ShouldQueue
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

    private const EXPORT_TYPE = 'grades_report_pdf';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Admin $admin,
        private readonly array $filters,
        private readonly string $locale = 'ar'
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService, GradesReportService $reportService): void
    {
        $fileName = $exportService->generateFileName('grades_report', 'pdf');
        $filePath = $exportService->getFilePath($fileName);
        $fullPath = Storage::disk($exportService->getDisk())->path($filePath);

        try {
            $this->ensureExportDirectoryExists($exportService);

            $data = $reportService->getGradesQuery($this->filters);

            // Only include charts when no filters are applied
            $includeCharts = empty($this->filters['grade_id'])
                && empty($this->filters['classroom_id'])
                && empty($this->filters['section_id'])
                && empty($this->filters['subject_id'])
                && empty($this->filters['exam_id']);

            $chartData = $includeCharts
                ? $reportService->getChartDataForPdf($this->filters, $this->locale)
                : null;

            $kpis = $reportService->getKPIs($this->filters);

            $html = $this->renderPdfView($data, $chartData, $kpis);

            $this->generatePdf($html, $fullPath);

            $this->admin->notify(
                new ExportReadyNotification($fileName, self::EXPORT_TYPE)
            );

            Log::info('Grades PDF export generated successfully', [
                'admin_id' => $this->admin->id,
                'file_name' => $fileName,
                'filters' => $this->filters,
                'records_count' => $data->count(),
                'include_charts' => $includeCharts,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to generate grades PDF export', [
                'admin_id' => $this->admin->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'filters' => $this->filters,
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
    private function renderPdfView($data, ?array $chartData, array $kpis): string
    {
        return view('admin.reports.grades.pdf_view', [
            'records' => $data,
            'chartData' => $chartData,
            'kpis' => $kpis,
            'generatedAt' => now(),
            'filters' => $this->filters,
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

        Log::error('Grades PDF export job failed after all retries', [
            'admin_id' => $this->admin->id,
            'error' => $exception?->getMessage(),
            'filters' => $this->filters,
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
            'grades',
            'admin:'.$this->admin->id,
        ];
    }
}
