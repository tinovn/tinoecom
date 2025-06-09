<?php

declare(strict_types=1);

namespace Tinoecom\Core\Observers;

use Tinoecom\Core\Models\ProductVariant;

final class ProductVariantObserver
{
    public function deleting(ProductVariant $variant): void
    {
        $variant->media()->delete();
        $variant->prices()->delete();
        $variant->clearStock();
    }
}
