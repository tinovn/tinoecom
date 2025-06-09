<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Tinoecom\Core\Models\Zone;

#[Layout('tinoecom::components.layouts.setting')]
class Zones extends Component
{
    #[Url(as: 'zone', except: '')]
    public ?int $currentZoneId = null;

    public function updatedCurrentZoneId(int $value): void
    {
        $this->currentZoneId = $value;

        $this->dispatch('zone.changed', currentZoneId: $value);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.zones', [
            'zones' => Zone::with(['carriers', 'countries'])->get(),
        ])
            ->title(__('tinoecom::pages/settings/zones.title'));
    }
}
