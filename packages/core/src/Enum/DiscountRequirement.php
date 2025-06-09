<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string None()
 * @method static string Price()
 * @method static string Quantity()
 */
enum DiscountRequirement: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case None = 'none';

    case Price = 'price';

    case Quantity = 'quantity';

    public function getLabel(): string
    {
        return match ($this) {
            self::None => __('tinoecom-core::enum/discount.requirement.none'),
            self::Price => __('tinoecom-core::enum/discount.requirement.min_amount'),
            self::Quantity => __('tinoecom-core::enum/discount.requirement.min_quantity'),
        };
    }
}
