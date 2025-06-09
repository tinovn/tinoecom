<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Infrastructure;

use Illuminate\Contracts\Container\Container;
use Tinoecom\Sidebar\Contracts\Sidebar;
use Tinoecom\Sidebar\Exceptions\LogicException;

final class ContainerResolver implements SidebarResolver
{
    public function __construct(protected Container $container) {}

    public function resolve(string $name): Sidebar
    {
        $sidebar = $this->container->make($name);

        if (! $sidebar instanceof Sidebar) {
            throw new LogicException('Your sidebar should implement the Sidebar interface');
        }

        $sidebar->build();

        return $sidebar;
    }
}
