<?php

declare(strict_types=1);

namespace Tinoecom\Providers;

use Illuminate\Support\ServiceProvider;
use Tinoecom\Events\CatalogSidebar;
use Tinoecom\Events\CustomerSidebar;
use Tinoecom\Events\DashboardSidebar;
use Tinoecom\Events\SalesSidebar;
use Tinoecom\Sidebar\AdminSidebar;
use Tinoecom\Sidebar\SidebarBuilder;
use Tinoecom\Sidebar\SidebarCreator;
use Tinoecom\Sidebar\SidebarManager;

final class SidebarServiceProvider extends ServiceProvider
{
    public function boot(SidebarManager $manager): void
    {
        $manager->register(AdminSidebar::class);
    }

    public function register(): void
    {
        $this->app['events']->listen(SidebarBuilder::class, DashboardSidebar::class);
        $this->app['events']->listen(SidebarBuilder::class, CatalogSidebar::class);
        $this->app['events']->listen(SidebarBuilder::class, SalesSidebar::class);
        $this->app['events']->listen(SidebarBuilder::class, CustomerSidebar::class);

        view()->creator('tinoecom::components.layouts.app.sidebar.secondary', SidebarCreator::class);
    }
}
