<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar;

use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Contracts\Sidebar;

final class AdminSidebar implements Sidebar
{
    public function __construct(protected Menu $menu) {}

    public function build(): void
    {
        event(new SidebarBuilder($this->menu));
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }
}
