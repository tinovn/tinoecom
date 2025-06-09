<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Customers;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Repositories\UserRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Show extends AbstractPageComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $customer;

    public function deleteAction(): Action
    {
        return Action::make(__('tinoecom::forms.actions.delete'))
            ->requiresConfirmation()
            ->icon('untitledui-trash-03')
            ->modalIcon('untitledui-trash-03')
            ->color('danger')
            ->action(function (): void {
                $this->customer->delete();

                Notification::make()
                    ->title(__('tinoecom::notifications.delete', ['item' => __('tinoecom::pages/customers.single')]))
                    ->success()
                    ->send();

                $this->redirectRoute(name: 'tinoecom.customers.index', navigate: true);
            });
    }

    public function mount(int $user): void
    {
        $this->authorize('read_customers');

        $this->customer = (new UserRepository)->with(['addresses', 'orders'])->getById($user);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.customers.show')
            ->title(__('tinoecom::forms.actions.show_label', ['label' => $this->customer->full_name]));
    }
}
