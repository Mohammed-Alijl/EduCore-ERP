<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateGeneralSettingRequest;
use App\Models\GeneralSetting;
use App\Services\AcademicYearService;
use App\Services\GeneralSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class GeneralSettingController extends Controller implements HasMiddleware
{
    public function __construct(
        protected GeneralSettingService $settingService,
        protected AcademicYearService $academicYearService
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:view_generalSettings', only: ['index']),
            new Middleware('permission:edit_generalSettings', only: ['update']),
        ];
    }

    /**
     * Display the general settings page.
     */
    public function index(): View
    {
        $settings = $this->settingService->get();
        $academicYears = $this->academicYearService->getAll();

        return view('admin.Settings.general.index', compact('settings', 'academicYears'));
    }

    /**
     * Update the general settings.
     */
    public function update(UpdateGeneralSettingRequest $request): JsonResponse
    {
        try {
            $settings = GeneralSetting::instance();
            $this->settingService->update($settings, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => trans('admin.Settings.general_settings.messages.success.update'),
            ]);
        } catch (\Exception $e) {
            Log::error('General settings update failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => trans('admin.Settings.general_settings.messages.failed.update'),
            ], 500);
        }
    }
}
