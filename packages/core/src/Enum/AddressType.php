<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Billing()
 * @method static string Shipping()
 */
enum AddressType: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Billing = 'billing';

    case Shipping = 'shipping';

    public function getLabel(): string
    {
        return match ($this) {
            self::Shipping => __('tinoecom-core::enum/address.shipping'),
            self::Billing => __('tinoecom-core::enum/address.billing'),
        };
    }
}
