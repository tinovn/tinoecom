<?php

declare(strict_types=1);

namespace Tinoecom\Http\Responses;

use Illuminate\Validation\ValidationException;
use Tinoecom\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;

class FailedTwoFactorLoginResponse implements FailedTwoFactorLoginResponseContract
{
    public function toResponse($request)
    {
        [$key, $message] = $request->filled('recovery_code')
            ? ['recovery_code', __('The provided two factor recovery code was invalid.')]
            : ['code', __('The provided two factor authentication code was invalid.')];

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([$key => $message]);
        }

        session()->flash('error', $message);

        return back()->withErrors([$key => $message]);
    }
}
