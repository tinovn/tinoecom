<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Infrastructure;

use Illuminate\Contracts\Cache\Repository;
use Tinoecom\Sidebar\Exceptions\CacheTagsNotSupported;

final class SupportsCacheTags
{
    public function isSatisfiedBy(Repository $repository): bool
    {
        if (! method_exists($repository->getStore(), 'tags')) {
            throw new CacheTagsNotSupported('Cache tags are necessary to use this kind of caching. Consider using a different caching method');
        }

        return true;
    }
}
