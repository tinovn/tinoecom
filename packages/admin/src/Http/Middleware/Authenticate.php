<?php

declare(strict_types=1);

namespace Tinoecom\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function authenticate($request, array $guards): void
    {
        $guardName = config('tinoecom.auth.guard');
        $guard = $this->auth->guard($guardName);

        if (! $guard->check()) {
            $this->unauthenticated($request, $guards);
        }

        $this->auth->shouldUse($guardName);
    }

    protected function redirectTo($request): string
    {
        return route('tinoecom.login');
    }
}
