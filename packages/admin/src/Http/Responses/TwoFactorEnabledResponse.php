<?php

declare(strict_types=1);

namespace Tinoecom\Http\Responses;

use Illuminate\Http\JsonResponse;
use Tinoecom\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorEnabledResponse implements TwoFactorLoginResponseContract
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 200)
            : back()->with('status', 'two-factor-authentication-enabled');
    }
}
