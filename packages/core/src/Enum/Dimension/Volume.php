<?php

declare(strict_types=1);

namespace Tinoecom\Core\Enum\Dimension;

use Tinoecom\Core\Traits\ArrayableEnum;
use Tinoecom\Core\Traits\HasEnumStaticMethods;

/**
 * @method static string L()
 * @method static string ML()
 * @method static string GAL()
 * @method static string FLOZ()
 */
enum Volume: string
{
    use ArrayableEnum;
    use HasEnumStaticMethods;

    case L = 'l';

    case ML = 'ml';

    case GAL = 'gal';

    case FLOZ = 'floz';
}
