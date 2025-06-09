<?php

declare(strict_types=1);

namespace Tinoecom;

use Tinoecom\Enum\FeatureState;

final class Feature
{
    /**
     * Determine if the given feature is enabled.
     */
    public static function enabled(string $feature): bool
    {
        return config('tinoecom.features.' . $feature) === FeatureState::Enabled;
    }
}
