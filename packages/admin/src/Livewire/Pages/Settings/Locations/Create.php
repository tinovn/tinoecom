<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings\Locations;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('tinoecom::components.layouts.setting')]
class Create extends Component
{
    public function mount(): void
    {
        $this->authorize('add_inventories');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.locations.create')
            ->title(__('tinoecom::pages/settings/global.location.add'));
    }
}
