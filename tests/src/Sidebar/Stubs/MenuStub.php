<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Tinoecom\Sidebar\Contracts\Builder\Menu;
use Tinoecom\Sidebar\Domain\DefaultMenu;

final class MenuStub extends DefaultMenu implements Menu {}
