<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Auth;

use Illuminate\Support\Collection;

class GenerateNewRecoveryCodes
{
    public function __invoke($user): void
    {
        $user->forceFill([
            'two_factor_recovery_codes' => encrypt(json_encode(
                Collection::times(8, fn () => RecoveryCode::generate())->all()
            )),
        ])->save();
    }
}
