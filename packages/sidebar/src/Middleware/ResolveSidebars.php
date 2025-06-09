<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tinoecom\Sidebar\SidebarManager;

class ResolveSidebars
{
    public function __construct(protected SidebarManager $sidebarManager) {}

    public function handle(Request $request, Closure $next)
    {
        $this->sidebarManager->resolve();

        return $next($request);
    }
}
