<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Illuminate\Container\Container;
use Mockery;
use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Contracts\SidebarExtender;
use Tinoecom\Sidebar\Domain\DefaultGroup;

final class SidebarExtenderStub implements SidebarExtender
{
    public function extendWith(Menu $menu): Menu
    {
        $container = Mockery::mock(Container::class);

        $group = new DefaultGroup($container);
        $group->setName('new from extender');
        $menu->addGroup($group);

        $group = new DefaultGroup($container);
        $group->setName('demo');
        $menu->addGroup($group);

        return $menu;
    }
}
