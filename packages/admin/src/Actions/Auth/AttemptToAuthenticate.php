<?php

declare(strict_types=1);

namespace Tinoecom\Actions\Auth;

use Closure;
use Illuminate\Validation\ValidationException;
use Tinoecom\Facades\Tinoecom;

class AttemptToAuthenticate
{
    public function handle(array $request, Closure $next)
    {
        $isLoggedIn = Tinoecom::auth()->attempt([
            'email' => $request['email'],
            'password' => $request['password'],
        ], $request['remember']);

        if (! $isLoggedIn) {
            $this->throwFailedAuthenticationException();
        }

        return $next($isLoggedIn);
    }

    protected function throwFailedAuthenticationException(): void
    {
        throw ValidationException::withMessages([
            'email' => __('tinoecom::pages/auth.login.failed'),
        ]);
    }
}
