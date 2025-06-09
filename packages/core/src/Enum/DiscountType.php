<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Percentage()
 * @method static string FixedAmount()
 */
enum DiscountType: string implements HasDescription, HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Percentage = 'percentage';

    case FixedAmount = 'fixed_amount';

    public function getLabel(): string
    {
        return match ($this) {
            self::Percentage => __('tinoecom-core::enum/discount.type.percentage'),
            self::FixedAmount => __('tinoecom-core::enum/discount.type.fixed_amount'),
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::Percentage => __('tinoecom-core::enum/discount.type.percentage_description'),
            self::FixedAmount => __('tinoecom-core::enum/discount.type.fixed_amount_description'),
        };
    }
}
