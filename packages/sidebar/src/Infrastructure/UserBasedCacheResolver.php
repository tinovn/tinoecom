<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Infrastructure;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Contracts\Config\Repository as Config;
use Tinoecom\Sidebar\Contracts\Sidebar;

final class UserBasedCacheResolver implements SidebarResolver
{
    public function __construct(
        protected ContainerResolver $resolver,
        protected Cache $cache,
        protected Guard $guard,
        protected Config $config
    ) {}

    public function resolve(string $name): Sidebar
    {
        if (! (new SupportsCacheTags)->isSatisfiedBy($this->cache)) {
            return $this->resolver->resolve($name);
        }

        $userId = $this->guard->check() ? $this->guard->user()->getAuthIdentifier() : null;
        $duration = $this->config->get('sidebar.cache.duration');

        return $this->cache->tags(CacheKey::get($name))->remember(CacheKey::get($name, $userId), $duration, fn () => $this->resolver->resolve($name));
    }
}
