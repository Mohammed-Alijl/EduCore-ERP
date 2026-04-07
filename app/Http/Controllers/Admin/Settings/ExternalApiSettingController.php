<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\ExternalApiSettingRequest;
use App\Models\Settings\ExternalApiSetting;
use App\Services\Settings\ExternalApiSettingService;
use Illuminate\View\View;

class ExternalApiSettingController extends Controller
{
    public function __construct(
        private readonly ExternalApiSettingService $settingService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $apis = $this->settingService->getAll();

        return view('admin.Settings.external-api.index', compact('apis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExternalApiSettingRequest $request, ExternalApiSetting $external_api_setting)
    {
        $this->settingService->update($external_api_setting, $request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('admin.Settings.external_api.messages.success.update'),
            ]);
        }

        return redirect()->route('admin.settings.external-api.index')
            ->with('success', __('admin.Settings.external_api.messages.success.update'));
    }

    /**
     * Toggle the active status of the API.
     */
    public function toggleStatus(ExternalApiSetting $external_api_setting)
    {
        $this->settingService->toggleStatus($external_api_setting);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => __('admin.Settings.external_api.messages.success.toggle'),
            ]);
        }

        return redirect()->back()
            ->with('success', __('admin.Settings.external_api.messages.success.toggle'));
    }
}
