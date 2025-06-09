<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Order()
 * @method static string Products()
 */
enum DiscountApplyTo: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Order = 'order';

    case Products = 'products';

    public function getLabel(): string
    {
        return match ($this) {
            self::Order => __('tinoecom-core::enum/discount.apply.entire_order'),
            self::Products => __('tinoecom-core::enum/discount.apply.specific_products'),
        };
    }
}
