<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Order;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Tinoecom\Core\Enum\OrderStatus;
use Tinoecom\Core\Events\Orders\AddNote;
use Tinoecom\Core\Events\Orders\Cancel;
use Tinoecom\Core\Events\Orders\Completed;
use Tinoecom\Core\Events\Orders\Paid;
use Tinoecom\Core\Events\Orders\Registered;
use Tinoecom\Core\Models\Order;
use Tinoecom\Core\Models\User;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

/**
 * @property-read User|null $customer
 */
class Detail extends AbstractPageComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithPagination;

    public Order $order;

    public int $perPage = 3;

    #[Validate('required|string')]
    public ?string $notes = null;

    public function mount(): void
    {
        $this->authorize('read_orders');

        $this->order->load('items', 'shippingAddress', 'billingAddress');
    }

    public function goToOrder(int $id): void
    {
        $this->redirectRoute('tinoecom.orders.detail', $id, navigate: true);
    }

    public function leaveNotes(): void
    {
        $this->validate();

        $this->order->update(['notes' => $this->notes]);

        event(new AddNote($this->order));

        Notification::make()
            ->body(__('tinoecom::pages/orders.notifications.note_added'))
            ->success()
            ->send();
    }

    #[Computed(persist: true)]
    public function customer(): ?User
    {
        return User::query()
            ->withCount('orders')
            ->find($this->order->customer_id);
    }

    public function cancelOrderAction(): Action
    {
        return Action::make('cancelOrder')
            ->label(__('tinoecom::forms.actions.cancel_order'))
            ->visible($this->order->canBeCancelled())
            ->action(function (): void {
                $this->order->update(['status' => OrderStatus::Cancelled()]);

                event(new Cancel($this->order));

                Notification::make()
                    ->body(__('tinoecom::pages/orders.notifications.cancelled'))
                    ->success()
                    ->send();
            });
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->label(__('tinoecom-core::status.registered'))
            ->visible($this->order->isPending())
            ->action(function (): void {
                $this->order->update(['status' => OrderStatus::Register()]);

                event(new Registered($this->order));

                Notification::make()
                    ->body(__('tinoecom::pages/orders.notifications.registered'))
                    ->success()
                    ->send();
            });
    }

    public function markPaidAction(): Action
    {
        return Action::make('markPaid')
            ->label(__('tinoecom::forms.actions.mark_paid'))
            ->visible($this->order->isPending() || $this->order->isRegister())
            ->action(function (): void {
                $this->order->update(['status' => OrderStatus::Paid()]);

                event(new Paid($this->order));

                Notification::make()
                    ->body(__('tinoecom::pages/orders.notifications.paid'))
                    ->success()
                    ->send();
            });
    }

    public function markCompleteAction(): Action
    {
        return Action::make('markComplete')
            ->label(__('tinoecom::forms.actions.mark_complete'))
            ->visible($this->order->isPaid())
            ->action(function (): void {
                $this->order->update(['status' => OrderStatus::Completed()]);

                event(new Completed($this->order));

                Notification::make()
                    ->body(__('tinoecom::pages/orders.notifications.completed'))
                    ->success()
                    ->send();
            });
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.orders.detail', [
            'items' => $this->order
                ->items()
                ->with('product', 'product.media', 'product.prices')
                ->simplePaginate($this->perPage),
            'nextOrder' => Order::query()
                ->where('id', '>', $this->order->id)
                ->oldest('id')
                ->first(),
            'prevOrder' => Order::query()
                ->where('id', '<', $this->order->id)
                ->latest('id')
                ->first(),
        ])
            ->title(__('tinoecom::pages/orders.show_title', ['number' => $this->order->number]));
    }
}
