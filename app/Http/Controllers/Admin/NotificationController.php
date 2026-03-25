<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Exports\ExportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        private readonly ExportService $exportService
    ) {}

    /**
     * Get notifications for the current admin (AJAX).
     */
    public function index(Request $request): JsonResponse
    {
        $admin = auth('admin')->user();

        $notifications = $admin->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(fn ($notification) => [
                'id' => $notification->id,
                'data' => $notification->data,
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans(),
            ]);

        $unreadCount = $admin->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(string $id): JsonResponse
    {
        $admin = auth('admin')->user();

        $notification = $admin->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.notifications.marked_as_read'),
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        $admin = auth('admin')->user();
        $admin->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.notifications.all_marked_as_read'),
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(string $id): JsonResponse
    {
        $admin = auth('admin')->user();

        $notification = $admin->notifications()->findOrFail($id);
        $notification->delete();

        return response()->json([
            'status' => 'success',
            'message' => trans('admin.notifications.deleted'),
        ]);
    }

    /**
     * Download export file and delete notification.
     */
    public function downloadExport(Request $request): \Symfony\Component\HttpFoundation\Response|RedirectResponse
    {
        $fileName = $request->input('file');

        if (empty($fileName) || ! $this->exportService->fileExists($fileName)) {
            return redirect()->back()->with('error', trans('admin.exports.errors.file_not_found'));
        }

        $notificationId = $request->input('notification_id');
        if ($notificationId) {
            $admin = auth('admin')->user();
            $notification = $admin->notifications()->find($notificationId);
            $notification?->delete();
        }

        return $this->exportService->download($fileName, deleteAfterSend: true);
    }

    /**
     * Get unread notifications count (lightweight endpoint for polling).
     */
    public function unreadCount(): JsonResponse
    {
        $count = auth('admin')->user()->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }
}
