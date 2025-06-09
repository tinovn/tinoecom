<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Paid()
 * @method static string Pending()
 * @method static string Completed()
 * @method static string Cancelled()
 */
enum PaymentStatus: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Paid = 'paid';

    case Pending = 'pending';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => __('tinoecom-core::status.pending'),
            self::Completed => __('tinoecom-core::status.completed'),
            self::Cancelled => __('tinoecom-core::status.cancelled'),
            self::Paid => __('tinoecom-core::status.paid'),
        };
    }
}
