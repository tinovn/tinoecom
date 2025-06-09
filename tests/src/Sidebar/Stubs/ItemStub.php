<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Tinoecom\Sidebar\Contracts\Builder\Item;
use Tinoecom\Sidebar\Domain\DefaultItem;

final class ItemStub extends DefaultItem implements Item {}
