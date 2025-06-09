<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Presentation;

use Illuminate\Contracts\View\View;
use Tinoecom\Sidebar\Contracts\Sidebar;

interface SidebarRenderer
{
    public function render(Sidebar $sidebar): ?View;
}
