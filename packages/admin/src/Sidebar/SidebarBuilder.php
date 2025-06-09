<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar;

use Tinoecom\Sidebar\Contracts\Builder\Menu;

final class SidebarBuilder
{
    public function __construct(protected Menu $menu) {}

    public function add(Menu $menu): void
    {
        $this->menu->add($menu);
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }
}
