<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Order;
use Tinoecom\Livewire\Components\ModalComponent;

class ArchiveOrder extends ModalComponent
{
    public Order $order;

    public function archived(): void
    {
        $this->order->delete();

        session()->flash('success', __('tinoecom::notifications.orders.archived'));

        $this->redirectRoute('tinoecom.orders.index', navigate: true);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.archive-order');
    }
}
