<?php

namespace App\Services;

use App\Models\GeneralSetting;
use App\Traits\UploadImageTrait;
use Illuminate\Support\Facades\Cache;

class GeneralSettingService
{
    use UploadImageTrait;

    private const CACHE_KEY = 'general_settings';

    private const CACHE_TTL = 86400;

    public function get(): GeneralSetting
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return GeneralSetting::instance()->load('currentAcademicYear');
        });
    }

    public function update(GeneralSetting $settings, array $data): GeneralSetting
    {
        if (isset($data['logo']) && $data['logo']) {
            if ($settings->logo) {
                $this->deleteImage($settings->logo);
            }
            $data['logo'] = $this->uploadImage($data['logo'], 'settings');
        }

        $settings->update($data);

        $this->clearCache();

        return $settings->fresh(['currentAcademicYear']);
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Get a specific setting value.
     */
    public function getValue(string $key, mixed $default = null): mixed
    {
        $settings = $this->get();

        return $settings->{$key} ?? $default;
    }
}
