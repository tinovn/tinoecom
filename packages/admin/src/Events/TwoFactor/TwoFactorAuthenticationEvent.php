<?php

declare(strict_types=1);

namespace Tinoecom\Events\TwoFactor;

use Illuminate\Foundation\Events\Dispatchable;

abstract class TwoFactorAuthenticationEvent
{
    use Dispatchable;

    public function __construct(public $user) {}
}
