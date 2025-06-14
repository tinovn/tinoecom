<?php

declare(strict_types=1);

namespace Tinoecom\Sidebar\Presentation;

use Illuminate\Support\Facades\Request;
use Tinoecom\Sidebar\Contracts\Builder\Item;

final class ActiveStateChecker
{
    public function isActive(Item $item): bool
    {
        foreach ($item->getItems() as $child) {
            if ($this->isActive($child)) {
                return true;
            }
        }

        if ($path = $item->getActiveWhen()) {
            return Request::is($path);
        }

        $path = mb_ltrim(str_replace(url('/'), '', $item->getUrl()), '/');

        return Request::is(
            $path,
            $path . '/*'
        );
    }
}
