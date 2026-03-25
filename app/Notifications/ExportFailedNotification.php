<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ExportFailedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly string $exportType,
        private readonly string $errorMessage,
        private readonly ?string $customTitle = null
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
            'type' => 'export_failed',
            'export_type' => $this->exportType,
            'title' => $this->customTitle ?? trans("admin.exports.{$this->exportType}.title"),
            'message' => trans('admin.exports.errors.failed_message', ['error' => $this->errorMessage]),
            'icon' => 'fas fa-exclamation-triangle',
            'icon_bg' => 'bg-danger',
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
