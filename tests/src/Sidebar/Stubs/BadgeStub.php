<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Tinoecom\Sidebar\Contracts\Builder\Badge;
use Tinoecom\Sidebar\Domain\DefaultBadge;

final class BadgeStub extends DefaultBadge implements Badge {}
