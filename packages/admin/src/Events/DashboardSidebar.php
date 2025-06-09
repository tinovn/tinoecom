<?php

declare(strict_types=1);

namespace Tinoecom\Events;

use Tinoecom\Sidebar\AbstractAdminSidebar;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Contracts\Builder\Menu;

final class DashboardSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group('', function (Group $group): void {
            $group->weight(1);
            $group->setAuthorized();

            $group->item(__('tinoecom::pages/dashboard.menu'), function (Item $item): void {
                $item->weight(1);
                $item->setItemClass('sh-sidebar-item group');
                $item->setActiveClass('sh-sidebar-item-active');
                $item->setInactiveClass('sh-sidebar-item-inactive');
                $item->useSpa();
                $item->route('tinoecom.dashboard');
                $item->setIcon(
                    icon: 'untitledui-home-line',
                    iconClass: 'mr-3 h-5 w-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400'),
                    attributes: [
                        'stroke-width' => '1.5',
                    ]
                );
            });
        });

        return $menu;
    }
}
