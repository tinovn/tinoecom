<?php

declare(strict_types=1);

namespace Tinoecom\Infrastructure;

use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Tinoecom\Sidebar\Contracts\Sidebar;
use Tinoecom\Sidebar\Infrastructure\CacheKey;
use Tinoecom\Sidebar\Infrastructure\ContainerResolver;
use Tinoecom\Sidebar\Infrastructure\SidebarResolver;

final class StaticCacheResolver implements SidebarResolver
{
    public function __construct(
        protected ContainerResolver $resolver,
        protected Cache $cache,
        protected Config $config
    ) {}

    public function resolve(string $name): Sidebar
    {
        $duration = $this->config->get('sidebar.cache.duration');

        return $this->cache->remember(CacheKey::get($name), $duration, fn () => $this->resolver->resolve($name));
    }
}
