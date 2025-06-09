<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar;

use Illuminate\Contracts\Auth\Authenticatable;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Contracts\SidebarExtender;

abstract class AbstractAdminSidebar implements SidebarExtender
{
    protected ?Authenticatable $user;

    public function __construct()
    {
        $this->user = Tinoecom::auth()->user();
    }

    public function handle(SidebarBuilder $sidebar): void
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    abstract public function extendWith(Menu $menu): Menu;
}
