<?php

declare(strict_types=1);

namespace Tinoecom\Core\Observers;

use Tinoecom\Core\Models\Product;

final class ProductObserver
{
    public function deleting(Product $product): void
    {
        $product->media()->delete();
        $product->prices()->delete();
        $product->clearStock();
    }
}
