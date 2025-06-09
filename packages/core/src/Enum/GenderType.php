<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum;

use Filament\Support\Contracts\HasLabel;
use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string Male()
 * @method static string Female()
 */
enum GenderType: string implements HasLabel
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case Male = 'male';

    case Female = 'female';

    public function getLabel(): string
    {
        return match ($this) {
            self::Male => __('tinoecom::words.male'),
            self::Female => __('tinoecom::words.female'),
        };
    }
}
