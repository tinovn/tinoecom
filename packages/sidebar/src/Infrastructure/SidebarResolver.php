<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Infrastructure;

use Tinoecom\Sidebar\Contracts\Sidebar;

interface SidebarResolver
{
    public function resolve(string $name): Sidebar;
}
