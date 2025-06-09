<?php

declare(strict_types=1);

namespace Tinoecom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (tinoecom()->auth()->check()) {
            return redirect()->route('tinoecom.dashboard');
        }

        return $next($request);
    }
}
