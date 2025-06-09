<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Settings\Zones;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Tinoecom\Core\Models\Zone;

/**
 * @property-read Zone $zone
 */
#[Lazy]
class Detail extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    #[Reactive]
    public ?int $currentZoneId = null;

    #[Computed]
    public function zone(): ?Zone
    {
        return Zone::with([
            'countries',
            'currency',
            'carriers',
            'paymentMethods',
        ])->find($this->currentZoneId);
    }

    public function deleteAction(): Action
    {
        return DeleteAction::make('delete')
            ->record($this->zone)
            ->icon('untitledui-trash-03')
            ->iconButton()
            ->successNotificationTitle(__('tinoecom::notifications.delete', ['item' => __('tinoecom::pages/settings/zones.single')]))
            ->after(function (): void {
                $this->reset('zone');

                $this->dispatch('refresh-zones');
            });
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->iconButton()
            ->icon('untitledui-edit-03')
            ->action(fn (array $arguments) => $this->dispatch(
                'openPanel',
                component: 'tinoecom-slide-overs.zone-form',
                arguments: ['zoneId' => $arguments['id']]
            ));
    }

    public function placeholder(): View
    {
        return view('tinoecom::placeholders.detail-zone');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.settings.zones.detail');
    }
}
