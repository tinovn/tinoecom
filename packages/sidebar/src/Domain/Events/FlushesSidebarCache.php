<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Domain\Events;

use Illuminate\Contracts\Container\Container;
use Tinoecom\Sidebar\SidebarManager;

final class FlushesSidebarCache
{
    public function __construct(
        protected Container $container,
        protected SidebarManager $manager
    ) {}

    public function handle(): void
    {
        $this->container->call([$this->manager, 'flush']);
    }
}
