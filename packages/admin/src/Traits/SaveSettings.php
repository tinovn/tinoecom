<?php

declare(strict_types=1);

namespace Tinoecom\Traits;

use Illuminate\Support\Facades\Cache;
use Tinoecom\Core\Models\Setting;

trait SaveSettings
{
    public function saveSettings(array $keys): void
    {
        foreach ($keys as $key => $value) {
            Cache::forget('tinoecom-setting.' . $key);

            Setting::query()->updateOrCreate(['key' => $key], [
                'value' => $value,
                'display_name' => Setting::lockedAttributesDisplayName($key),
                'locked' => true,
            ]);
        }
    }
}
