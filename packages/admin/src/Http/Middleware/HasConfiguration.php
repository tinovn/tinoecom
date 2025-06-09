<?php

declare(strict_types=1);

namespace Tinoecom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasConfiguration
{
    public function handle(Request $request, Closure $next)
    {
        if (tinoecom_setting('email') && tinoecom_setting('street_address')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['setup' => true]);
            }

            return redirect()->route('tinoecom.dashboard');
        }

        return $next($request);
    }
}
