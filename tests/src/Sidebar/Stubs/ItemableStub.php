<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Tinoecom\Sidebar\Contracts\Builder\Itemable;
use Tinoecom\Sidebar\Traits\CallableTrait;
use Tinoecom\Sidebar\Traits\ItemableTrait;

final class ItemableStub implements Itemable
{
    use CallableTrait;
    use ItemableTrait;

    public function __construct(private Container $container)
    {
        $this->items = new Collection;
    }
}
