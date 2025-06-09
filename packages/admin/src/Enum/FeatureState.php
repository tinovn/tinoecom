<?php

declare(strict_types=1);

namespace Tinoecom\Enum;

use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Enabled()
 * @method static string Disabled()
 */
enum FeatureState: string
{
    use HasEnumStaticMethods;

    case Enabled = 'enabled';

    case Disabled = 'disabled';
}
