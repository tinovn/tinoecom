<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Contracts;

use Tinoecom\Sidebar\Contracts\Builder\Menu;

interface SidebarExtender
{
    public function extendWith(Menu $menu): Menu;
}
