<?php

declare(strict_types=1);

namespace Tinoecom\Infrastructure;

use Tinoecom\Sidebar\Infrastructure\SidebarFlusher;

final class NullSidebarFlusher implements SidebarFlusher
{
    public function flush(string $name): void {}
}
