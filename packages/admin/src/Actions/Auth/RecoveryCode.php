<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Auth;

use Illuminate\Support\Str;

class RecoveryCode
{
    public static function generate(): string
    {
        return Str::random(10) . '-' . Str::random(10);
    }
}
