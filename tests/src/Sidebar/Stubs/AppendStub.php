<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Tinoecom\Sidebar\Contracts\Builder\Append;
use Tinoecom\Sidebar\Domain\DefaultAppend;

final class AppendStub extends DefaultAppend implements Append {}
