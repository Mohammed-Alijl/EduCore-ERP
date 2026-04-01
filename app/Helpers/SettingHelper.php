<?php

use App\Models\GeneralSetting;
use App\Services\GeneralSettingService;

if (! function_exists('setting')) {
    /**
     * Get a general setting value.
     *
     * @param  string|null  $key  The setting key (e.g., 'school_name', 'email')
     * @param  mixed  $default  Default value if setting not found
     * @return mixed|GeneralSetting
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $service = app(GeneralSettingService::class);

        if ($key === null) {
            return $service->get();
        }

        return $service->getValue($key, $default);
    }
}
