<?php

declare(strict_types=1);

namespace Tinoecom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tinoecom\Core\Models\User;
use Tinoecom\Facades\Tinoecom;

class Dashboard
{
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = Tinoecom::auth()->user();

        if (! $user->isAdmin() && ! $user->hasPermissionTo('access_dashboard')) {
            abort(403, __('Unauthorized'));
        }

        if (is_null(tinoecom_setting('email')) || is_null(tinoecom_setting('street_address'))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response(__('Unauthorized'), Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->route('tinoecom.initialize');
        }

        return $next($request);
    }
}
