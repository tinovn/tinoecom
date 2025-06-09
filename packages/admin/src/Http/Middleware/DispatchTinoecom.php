<?php

declare(strict_types=1);

namespace Tinoecom\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tinoecom\Events\LoadTinoecom;

class DispatchTinoecom
{
    public function handle(Request $request, Closure $next)
    {
        LoadTinoecom::dispatch();

        return $next($request);
    }
}
