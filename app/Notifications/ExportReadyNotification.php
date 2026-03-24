<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExportReadyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly string $fileName,
        private readonly string $exportType,
        private readonly ?string $customTitle = null,
        private readonly ?string $customMessage = null
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'export_ready',
            'export_type' => $this->exportType,
            'title' => $this->customTitle ?? trans("admin.exports.{$this->exportType}.title"),
            'message' => $this->customMessage ?? trans("admin.exports.{$this->exportType}.ready_message"),
            'file_name' => $this->fileName,
            'download_url' => route('admin.exports.download', ['file' => $this->fileName]),
            'icon' => 'fas fa-file-excel',
            'icon_bg' => 'bg-success',
            'created_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
