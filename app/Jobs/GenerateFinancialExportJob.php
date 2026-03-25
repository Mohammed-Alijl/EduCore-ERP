<?php

namespace App\Jobs;

use App\Exports\FinancialExport;
use App\Models\Admin;
use App\Notifications\ExportFailedNotification;
use App\Notifications\ExportReadyNotification;
use App\Services\Exports\ExportService;
use App\Services\Reports\FinancialReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class GenerateFinancialExportJob implements ShouldQueue
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

    private const EXPORT_TYPE = 'financial_report';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Admin $admin
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService, FinancialReportService $financialService): void
    {
        $fileName = $exportService->generateFileName('financial_report');
        $filePath = $exportService->getFilePath($fileName);

        try {
            Excel::store(
                new FinancialExport($financialService),
                $filePath,
                $exportService->getDisk()
            );

            $this->admin->notify(
                new ExportReadyNotification($fileName, self::EXPORT_TYPE)
            );

            Log::info('Financial export generated successfully', [
                'admin_id' => $this->admin->id,
                'file_name' => $fileName,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to generate financial export', [
                'admin_id' => $this->admin->id,
                'error' => $e->getMessage(),
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

        Log::error('Financial export job failed after all retries', [
            'admin_id' => $this->admin->id,
            'error' => $exception?->getMessage(),
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
            'finance',
            'admin:'.$this->admin->id,
        ];
    }
}
