<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Awaiting()
 * @method static string Pending()
 * @method static string Treatment()
 * @method static string Partial_Refund()
 * @method static string Refunded()
 * @method static string Rejected()
 * @method static string Cancelled()
 */
enum OrderRefundStatus: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Awaiting = 'awaiting';

    case Pending = 'pending';

    case Treatment = 'treatment';

    case Partial_Refund = 'partial_refund';

    case Refunded = 'refunded';

    case Rejected = 'rejected';

    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Awaiting => __('tinoecom-core::status.awaiting'),
            self::Pending => __('tinoecom-core::status.pending'),
            self::Treatment => __('tinoecom-core::status.treatment'),
            self::Partial_Refund => __('tinoecom-core::status.partial-refund'),
            self::Refunded => __('tinoecom-core::status.refunded'),
            self::Rejected => __('tinoecom-core::status.rejected'),
            self::Cancelled => __('tinoecom-core::status.cancelled'),
        };
    }
}
