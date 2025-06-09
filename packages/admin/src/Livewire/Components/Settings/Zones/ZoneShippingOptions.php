<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Settings\Zones;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Core\Models\CarrierOption;
use Tinoecom\Core\Models\Zone;

/**
 * @property-read Zone $zone
 */
#[Lazy]
class ZoneShippingOptions extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?int $selectedZoneId = null;

    #[On('zone.changed')]
    public function updatedSelectedZone(int $currentZoneId): void
    {
        $this->selectedZoneId = $currentZoneId;
    }

    #[Computed]
    public function zone(): ?Zone
    {
        return Zone::with(['shippingOptions'])->find($this->selectedZoneId);
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->icon('untitledui-trash-03')
            ->color('danger')
            ->iconButton()
            ->action(function (array $arguments): void {
                CarrierOption::query()->find($arguments['id'])->delete();

                Notification::make()
                    ->title(__('tinoecom::notifications.delete', ['item' => __('tinoecom::pages/settings/zones.shipping_options.single')]))
                    ->success()
                    ->send();

                $this->dispatch('$refresh');
            });
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->iconButton()
            ->icon('untitledui-edit-03')
            ->action(fn (array $arguments) => $this->dispatch(
                'openPanel',
                component: 'tinoecom-slide-overs.shipping-option-form',
                arguments: ['zoneId' => $arguments['zone_id'], 'optionId' => $arguments['option_id']]
            ));
    }

    public function placeholder(): View
    {
        return view('tinoecom::placeholders.detail-zone');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.settings.zones.shipping-options');
    }
}
