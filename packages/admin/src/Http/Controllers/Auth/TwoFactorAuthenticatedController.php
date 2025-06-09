<?php

declare(strict_types=1);

namespace Tinoecom\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Http\Middleware\RedirectIfAuthenticated;
use Tinoecom\Http\Requests\TwoFactorLoginRequest;
use Tinoecom\Http\Responses\FailedTwoFactorLoginResponse;

final class TwoFactorAuthenticatedController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfAuthenticated::class);
    }

    public function create(TwoFactorLoginRequest $request): View
    {
        if (! $request->hasChallengedUser()) {
            throw new HttpResponseException(redirect()->route('tinoecom.login'));
        }

        return view('tinoecom::auth.two-factor-login');
    }

    public function store(TwoFactorLoginRequest $request): FailedTwoFactorLoginResponse | JsonResponse | RedirectResponse
    {
        $user = $request->challengedUser();

        if ($code = $request->validRecoveryCode()) {
            $user->replaceRecoveryCode($code);
        } elseif (! $request->hasValidCode()) {
            return app(FailedTwoFactorLoginResponse::class);
        }

        Tinoecom::auth()->login($user, $request->remember());

        $request->session()->regenerate();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect(route('tinoecom.dashboard'));
    }
}
