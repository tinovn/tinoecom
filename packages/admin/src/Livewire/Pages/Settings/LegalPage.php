<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Tinoecom\Core\Models\Legal;

#[Layout('tinoecom::components.layouts.setting')]
class LegalPage extends Component
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.legal', [
            'legals' => Legal::query()->get()->mapWithKeys(fn (Legal $item) => [$item->slug => $item]),
        ])
            ->title(__('tinoecom::pages/settings/global.legal.title'));
    }
}
