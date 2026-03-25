<?php

namespace App\Services\Exports;

use Illuminate\Support\Facades\Storage;

class ExportService
{
    private const EXPORT_DISK = 'local';

    private const EXPORT_PATH = 'exports';

    /**
     * Generate a unique filename for an export.
     */
    public function generateFileName(string $prefix, string $extension = 'xlsx'): string
    {
        return sprintf(
            '%s_%s_%s.%s',
            $prefix,
            now()->format('Y-m-d_His'),
            uniqid(),
            $extension
        );
    }

    /**
     * Get the full storage path for a file.
     */
    public function getFilePath(string $fileName): string
    {
        return self::EXPORT_PATH.'/'.$fileName;
    }

    /**
     * Check if an export file exists.
     */
    public function fileExists(string $fileName): bool
    {
        return Storage::disk(self::EXPORT_DISK)->exists($this->getFilePath($fileName));
    }

    /**
     * Download an export file and optionally delete it after sending.
     */
    public function download(string $fileName, bool $deleteAfterSend = true)
    {
        $filePath = $this->getFilePath($fileName);

        if (! $this->fileExists($fileName)) {
            abort(404, trans('admin.exports.errors.file_not_found'));
        }

        $fullPath = Storage::disk(self::EXPORT_DISK)->path($filePath);
        $response = response()->download($fullPath);

        if ($deleteAfterSend) {
            $response->deleteFileAfterSend(true);
        }

        return $response;
    }

    /**
     * Delete an export file.
     */
    public function delete(string $fileName): bool
    {
        $filePath = $this->getFilePath($fileName);

        if ($this->fileExists($fileName)) {
            return Storage::disk(self::EXPORT_DISK)->delete($filePath);
        }

        return false;
    }

    /**
     * Clean up old export files (older than the specified hours).
     */
    public function cleanupOldFiles(int $hoursOld = 24): int
    {
        $deletedCount = 0;
        $files = Storage::disk(self::EXPORT_DISK)->files(self::EXPORT_PATH);
        $threshold = now()->subHours($hoursOld)->timestamp;

        foreach ($files as $file) {
            $lastModified = Storage::disk(self::EXPORT_DISK)->lastModified($file);

            if ($lastModified < $threshold) {
                Storage::disk(self::EXPORT_DISK)->delete($file);
                $deletedCount++;
            }
        }

        return $deletedCount;
    }

    /**
     * Get the storage disk name.
     */
    public function getDisk(): string
    {
        return self::EXPORT_DISK;
    }

    /**
     * Get the base export path.
     */
    public function getBasePath(): string
    {
        return self::EXPORT_PATH;
    }
}
