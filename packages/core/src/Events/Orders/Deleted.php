<?php

declare(strict_types=1);

namespace Tinoecom\Core\Events\Orders;

use Illuminate\Queue\SerializesModels;
use Tinoecom\Core\Models\Order;

class Deleted
{
    use SerializesModels;

    public function __construct(public Order $order) {}
}
