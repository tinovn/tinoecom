<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Contracts;

use Tinoecom\Sidebar\Contracts\Builder\Menu;

interface Sidebar
{
    public function build();

    public function getMenu(): Menu;
}
