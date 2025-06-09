<?php

declare(strict_types=1);

namespace Tinoecom\Http\Responses;

use Tinoecom\Contracts\LoginResponse as Responsable;

class LoginResponse implements Responsable
{
    public function toResponse($request)
    {
        return redirect()->intended(route('tinoecom.dashboard'));
    }
}
