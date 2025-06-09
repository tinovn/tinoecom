<?php

declare(strict_types=1);

namespace Tinoecom\Events;

use Tinoecom\Feature;
use Tinoecom\Sidebar\AbstractAdminSidebar;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Contracts\Builder\Menu;

final class CatalogSidebar extends AbstractAdminSidebar
{
    public function extendWith(Menu $menu): Menu
    {
        $menu->group(__('tinoecom::layout.sidebar.catalog'), function (Group $group): void {
            $group->weight(2);
            $group->setAuthorized();
            $group->setGroupItemsClass('space-y-1');
            $group->setHeadingClass('sh-heading');

            $group->item(__('tinoecom::pages/products.menu'), function (Item $item): void {
                $item->weight(1);
                $item->setAuthorized($this->user->hasPermissionTo('browse_products'));
                $item->setItemClass('sh-sidebar-item group');
                $item->setActiveClass('sh-sidebar-item-active');
                $item->setInactiveClass('sh-sidebar-item-inactive');
                $item->useSpa();
                $item->route('tinoecom.products.index');
                $item->setIcon(
                    icon: 'untitledui-book-open',
                    iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                    attributes: [
                        'stroke-width' => '1.5',
                    ],
                );

                if (Feature::enabled('attribute')) {
                    $item->item(__('tinoecom::pages/attributes.menu'), function (Item $item): void {
                        $item->weight(1);
                        $item->setAuthorized($this->user->hasPermissionTo('browse_products') || $this->user->hasPermissionTo('browse_attributes'));
                        $item->setItemClass('sh-sidebar-item-submenu group');
                        $item->setActiveClass('sh-sidebar-item-submenu-active');
                        $item->setInactiveClass('sh-sidebar-item-submenu-inactive');
                        $item->useSpa();
                        $item->route('tinoecom.attributes.index');
                    });
                }
            });

            if (Feature::enabled('category')) {
                $group->item(__('tinoecom::pages/categories.menu'), function (Item $item): void {
                    $item->weight(2);
                    $item->setAuthorized($this->user->hasPermissionTo('browse_categories'));
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('tinoecom.categories.index');
                    $item->setIcon(
                        icon: 'untitledui-tag-03',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });
            }

            if (Feature::enabled('collection')) {
                $group->item(__('tinoecom::pages/collections.menu'), function (Item $item): void {
                    $item->weight(3);
                    $item->setAuthorized($this->user->hasPermissionTo('browse_collections'));
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('tinoecom.collections.index');
                    $item->setIcon(
                        icon: 'untitledui-align-horizontal-centre-02',
                        iconClass: 'size-5 ' . ($item->isActive() ? 'text-primary-600' : 'text-gray-400 dark:text-gray-500'),
                        attributes: [
                            'stroke-width' => '1.5',
                        ],
                    );
                });
            }

            if (Feature::enabled('brand')) {
                $group->item(__('tinoecom::pages/brands.menu'), function (Item $item): void {
                    $item->weight(4);
                    $item->setAuthorized($this->user->hasPermissionTo('browse_brands'));
                    $item->setItemClass('sh-sidebar-item group');
                    $item->setActiveClass('sh-sidebar-item-active');
                    $item->setInactiveClass('sh-sidebar-item-inactive');
                    $item->useSpa();
                    $item->route('tinoecom.brands.index');
                    $item->setIcon(
                        icon: 'untitledui-bookmark',
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
