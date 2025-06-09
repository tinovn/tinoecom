<?php

declare(strict_types=1);

namespace Tinoecom\Http\Responses;

use Illuminate\Http\JsonResponse;
use Tinoecom\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->intended(route('tinoecom.dashboard'));
    }
}
