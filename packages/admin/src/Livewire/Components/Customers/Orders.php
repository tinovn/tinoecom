<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Customers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Tinoecom\Core\Models\Order;

class Orders extends Component
{
    public $customer;

    #[Computed(persist: true)]
    public function orders(): Paginator
    {
        return Order::with([
            'items',
            'items.product',
            'items.product.media',
            'shippingAddress',
            'paymentMethod',
            'shippingOption',
        ])
            ->whereBelongsTo($this->customer, 'customer')
            ->latest()
            ->simplePaginate(3);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.customers.orders');
    }
}
