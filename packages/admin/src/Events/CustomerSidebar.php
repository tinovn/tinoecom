<?php

declare(strict_types=1);

namespace Tinoecom\Events;

use Tinoecom\Feature;
use Tinoecom\Sidebar\AbstractAdminSidebar;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Contracts\Builder\Menu;

final class CustomerSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('tinoecom::pages/customers.menu'), function (Group $group): void {
            $group->weight(3);
            $group->setAuthorized();
            $group->setGroupItemsClass('space-y-1');
            $group->setHeadingClass('sh-heading');

            $group->item(__('tinoecom::pages/customers.menu'), function (Item $item): void {
                $item->weight(1);
                $item->setAuthorized($this->user->hasPermissionTo('browse_customers'));
                $item->setItemClass('sh-sidebar-item group');
                $item->setActiveClass('sh-sidebar-item-active');
                $item->setInactiveClass('sh-sidebar-item-inactive');
                $item->route('tinoecom.customers.index');
                $item->useSpa();
                $item->setIcon(
                    icon: 'untitledui-users-02',
                    iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                    attributes: [
                        'stroke-width' => '1.5',
                    ],
                );
            });

            if (Feature::enabled('review')) {
                $group->item(__('tinoecom::pages/reviews.menu'), function (Item $item): void {
                    $item->weight(2);
                    $item->setAuthorized($this->user->hasPermissionTo('browse_products'));
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->route('tinoecom.reviews.index');
                    $item->useSpa();
                    $item->setIcon(
                        icon: 'untitledui-message-heart-square',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });
            }
        });

        return $menu;
    }
}
