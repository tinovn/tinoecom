<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Manual()
 * @method static string Auto()
 */
enum CollectionType: string implements HasDescription, HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Manual = 'manual';

    case Auto = 'auto';

    public function getLabel(): string
    {
        return match ($this) {
            self::Manual => __('tinoecom-core::enum/collection.manual'),
            self::Auto => __('tinoecom-core::enum/collection.automatic'),
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Manual => __('tinoecom-core::enum/collection.manual_description'),
            self::Auto => __('tinoecom-core::enum/collection.automatic_description'),
        };
    }
}
