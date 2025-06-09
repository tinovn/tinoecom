<?php

declare(strict_types=1);

namespace Tinoecom\Tests\Sidebar\Stubs;

use Illuminate\Container\Container;
use Tinoecom\Sidebar\Traits\RouteableTrait;

final class RouteableStub
{
    use RouteableTrait;

    public function __construct(private Container $container) {}
}
