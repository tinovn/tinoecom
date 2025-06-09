<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar;

use Illuminate\Foundation\Application;
use Tinoecom\Sidebar\Contracts\Builder\Append;
use Tinoecom\Sidebar\Contracts\Builder\Badge;
use Tinoecom\Sidebar\Contracts\Builder\Group;
use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Domain\DefaultAppend;
use Tinoecom\Sidebar\Domain\DefaultBadge;
use Tinoecom\Sidebar\Domain\DefaultGroup;
use Tinoecom\Sidebar\Domain\DefaultItem;
use Tinoecom\Sidebar\Domain\DefaultMenu;
use Tinoecom\Sidebar\Infrastructure\SidebarFlusher;
use Tinoecom\Sidebar\Infrastructure\SidebarFlusherFactory;
use Tinoecom\Sidebar\Infrastructure\SidebarResolver;
use Tinoecom\Sidebar\Infrastructure\SidebarResolverFactory;
use Tinoecom\Sidebar\Presentation\SidebarRenderer;
use Tinoecom\Sidebar\Presentation\View\SidebarRenderer as IlluminateSidebarRenderer;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class SidebarServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('sidebar')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->app->bind(SidebarResolver::class, function (Application $app) {
            $resolver = SidebarResolverFactory::getClassName(
                name: $app['config']->get('sidebar.cache.method')
            );

            return $app->make($resolver);
        });

        $this->app->bind(SidebarFlusher::class, function (Application $app) {
            $flusher = SidebarFlusherFactory::getClassName(
                name: $app['config']->get('sidebar.cache.method')
            );

            return $app->make($flusher);
        });

        $this->app->singleton(SidebarManager::class);

        $this->bindingSidebarMenu();
    }

    public function bindingSidebarMenu(): void
    {
        $this->app->bind(Menu::class, DefaultMenu::class);
        $this->app->bind(Group::class, DefaultGroup::class);
        $this->app->bind(Item::class, DefaultItem::class);
        $this->app->bind(Badge::class, DefaultBadge::class);
        $this->app->bind(Append::class, DefaultAppend::class);
        $this->app->bind(SidebarRenderer::class, IlluminateSidebarRenderer::class);
    }
}
