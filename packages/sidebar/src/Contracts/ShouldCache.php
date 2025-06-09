<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Contracts;

use Serializable;

interface ShouldCache extends Serializable
{
    public function getCacheables(): array;
}
