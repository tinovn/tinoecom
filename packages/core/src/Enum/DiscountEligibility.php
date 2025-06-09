<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Everyone()
 * @method static string Customers()
 */
enum DiscountEligibility: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Everyone = 'everyone';

    case Customers = 'customers';

    public function getLabel(): string
    {
        return match ($this) {
            self::Everyone => __('tinoecom-core::enum/discount.eligibility.everyone'),
            self::Customers => __('tinoecom-core::enum/discount.eligibility.specific_customers'),
        };
    }
}
