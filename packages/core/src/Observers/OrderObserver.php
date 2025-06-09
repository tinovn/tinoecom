<?php

declare(strict_types=1);

namespace Tinoecom\Core\Observers;

use Tinoecom\Core\Events\Orders\Created;
use Tinoecom\Core\Events\Orders\Deleted;
use Tinoecom\Core\Models\Order;

final class OrderObserver
{
    public function created(Order $order): void
    {
        event(new Created($order));
    }

    public function deleting(Order $order): void
    {
        event(new Deleted($order));
    }
}
