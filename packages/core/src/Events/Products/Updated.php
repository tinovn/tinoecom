<?php

declare(strict_types=1);

namespace Tinoecom\Core\Events\Products;

use Illuminate\Queue\SerializesModels;
use Tinoecom\Core\Models\Product;

class Updated
{
    use SerializesModels;

    public function __construct(public Product $product) {}
}
