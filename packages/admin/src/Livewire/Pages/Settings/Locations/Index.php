<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings\Locations;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Tinoecom\Core\Models\Inventory;

#[Layout('tinoecom::components.layouts.setting')]
class Index extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function mount(): void
    {
        $this->authorize('browse_inventories');
    }

    public function removeAction(): Action
    {
        return Action::make('remove')
            ->iconButton()
            ->icon('untitledui-trash-03')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                Inventory::query()->find($arguments['id'])->delete();

                Notification::make()
                    ->title(__('tinoecom::notifications.delete', ['item' => __('tinoecom::pages/settings/global.location.single')]))
                    ->success()
                    ->send();

                $this->dispatch('$refresh');
            })
            ->visible(
                tinoecom()
                    ->auth()
                    ->user()
                    ->can('delete_inventories')
            );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.locations.index', [
            'inventories' => Inventory::query()
                ->with('country')
                ->limit(config('tinoecom.admin.inventory_limit'))
                ->get(),
        ])->title(__('tinoecom::pages/settings/global.location.menu'));
    }
}
