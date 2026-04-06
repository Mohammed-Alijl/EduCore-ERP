<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Scheduling\DayOfWeek;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class DayOfWeekController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_daysOfWeek', only: ['index']),
            new Middleware('permission:edit_daysOfWeek', only: ['update']),
        ];
    }

    /**
     * Display the days of week settings page.
     */
    public function index(): View
    {
        $days = DayOfWeek::ordered()->get();

        return view('admin.Settings.days_of_week.index', compact('days'));
    }

    /**
     * Update the specified day's status.
     */
    public function update(Request $request, DayOfWeek $dayOfWeek): JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        try {
            $dayOfWeek->update([
                'is_active' => $request->boolean('is_active'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Settings.days_of_week.messages.success.update'),
                'day' => [
                    'id' => $dayOfWeek->id,
                    'name' => $dayOfWeek->name,
                    'is_active' => $dayOfWeek->is_active,
                    'is_weekend' => $dayOfWeek->is_weekend,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Day of week update failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Settings.days_of_week.messages.failed.update'),
            ], 500);
        }
    }

    /**
     * Toggle all days' active status.
     */
    public function toggleAll(Request $request): JsonResponse
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        try {
            DayOfWeek::query()->update([
                'is_active' => $request->boolean('is_active'),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Settings.days_of_week.messages.success.toggle_all'),
            ]);
        } catch (\Exception $e) {
            Log::error('Days of week toggle all failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Settings.days_of_week.messages.failed.toggle_all'),
            ], 500);
        }
    }
}
