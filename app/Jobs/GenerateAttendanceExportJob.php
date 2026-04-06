<?php

namespace App\Jobs;

use App\Exports\AttendanceExport;
use App\Models\Users\Admin;
use App\Notifications\ExportFailedNotification;
use App\Notifications\ExportReadyNotification;
use App\Services\Exports\ExportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class GenerateAttendanceExportJob implements ShouldQueue
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

    private const EXPORT_TYPE = 'attendance_report';

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Admin $admin,
        private readonly int $academicYearId,
        private readonly ?int $gradeId = null,
        private readonly ?int $sectionId = null
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService): void
    {
        $fileName = $exportService->generateFileName('attendance_report');
        $filePath = $exportService->getFilePath($fileName);

        try {
            Excel::store(
                new AttendanceExport(
                    $this->academicYearId,
                    $this->gradeId,
                    $this->sectionId
                ),
                $filePath,
                $exportService->getDisk()
            );

            $this->admin->notify(
                new ExportReadyNotification($fileName, self::EXPORT_TYPE)
            );

            Log::info('Attendance export generated successfully', [
                'admin_id' => $this->admin->id,
                'file_name' => $fileName,
                'academic_year_id' => $this->academicYearId,
                'grade_id' => $this->gradeId,
                'section_id' => $this->sectionId,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to generate attendance export', [
                'admin_id' => $this->admin->id,
                'error' => $e->getMessage(),
                'academic_year_id' => $this->academicYearId,
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

        Log::error('Attendance export job failed after all retries', [
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
            'attendance',
            'admin:'.$this->admin->id,
        ];
    }
}
