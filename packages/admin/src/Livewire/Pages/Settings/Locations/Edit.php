<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings\Locations;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Tinoecom\Core\Models\Inventory;

#[Layout('tinoecom::components.layouts.setting')]
class Edit extends Component
{
    public Inventory $inventory;

    public function mount(): void
    {
        $this->authorize('edit_inventories');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.locations.edit')
            ->title(__('tinoecom::pages/settings/global.location.menu') . ' ~ ' . $this->inventory->name);
    }
}
