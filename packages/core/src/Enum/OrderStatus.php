<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string New()
 * @method static string Shipped()
 * @method static string Delivered()
 * @method static string Paid()
 * @method static string Pending()
 * @method static string Register()
 * @method static string Completed()
 * @method static string Cancelled()
 */
enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case New = 'new';

    case Shipped = 'shipped';

    case Delivered = 'delivered';

    case Pending = 'pending';

    case Paid = 'paid';

    case Register = 'registered';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    public function getColor(): string
    {
        return match ($this) {
            self::New => 'info',
            self::Cancelled => 'danger',
            self::Completed => 'teal',
            self::Delivered => 'sky',
            self::Paid => 'green',
            self::Pending => 'warning',
            self::Register => 'primary',
            self::Shipped => 'indigo',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::New => 'untitledui-stars-02',
            self::Shipped => 'heroicon-o-truck',
            self::Delivered => 'untitledui-package-check',
            self::Pending => 'untitledui-hourglass-03',
            self::Paid => 'heroicon-o-banknotes',
            self::Register => 'untitledui-file-check-02',
            self::Completed => 'heroicon-o-check-badge',
            self::Cancelled => 'heroicon-o-minus-circle',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::New => __('tinoecom-core::status.new'),
            self::Completed => __('tinoecom-core::status.completed'),
            self::Cancelled => __('tinoecom-core::status.cancelled'),
            self::Delivered => __('tinoecom-core::status.delivered'),
            self::Paid => __('tinoecom-core::status.paid'),
            self::Pending => __('tinoecom-core::status.pending'),
            self::Register => __('tinoecom-core::status.registered'),
            self::Shipped => __('tinoecom-core::status.shipped'),
        };
    }
}
