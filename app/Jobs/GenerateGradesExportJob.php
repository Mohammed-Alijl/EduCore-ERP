<?php

namespace App\Jobs;

use App\Exports\GradesExport;
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
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class GenerateGradesExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The maximum number of seconds the job should run.
     */
    public int $timeout = 300;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;

    private const EXPORT_TYPE = 'grades_report';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Admin $admin,
        private readonly array $filters
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService, GradesReportService $gradesService): void
    {
        $fileName = $exportService->generateFileName('grades_report');
        $filePath = $exportService->getFilePath($fileName);

        try {
            Excel::store(
                new GradesExport($gradesService, $this->filters),
                $filePath,
                $exportService->getDisk()
            );

            $this->admin->notify(
                new ExportReadyNotification($fileName, self::EXPORT_TYPE)
            );

            Log::info('Grades export generated successfully', [
                'admin_id' => $this->admin->id,
                'file_name' => $fileName,
                'filters' => $this->filters,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to generate grades export', [
                'admin_id' => $this->admin->id,
                'error' => $e->getMessage(),
                'filters' => $this->filters,
            ]);

            throw $e;
        }
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

        Log::error('Grades export job failed after all retries', [
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
            'grades',
            'admin:'.$this->admin->id,
        ];
    }
}
