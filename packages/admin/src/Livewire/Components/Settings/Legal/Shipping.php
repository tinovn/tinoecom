<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Settings\Legal;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Tinoecom\Core\Models\Legal;

class Shipping extends Component
{
    public Legal $legal;

    public function render(): View
    {
        return view('tinoecom::livewire.components.settings.legal.index', [
            'title' => __('tinoecom::pages/settings/global.legal.shipping'),
            'description' => __('tinoecom::pages/settings/global.legal.summary', ['policy' => __('tinoecom::pages/settings/global.legal.shipping')]),
        ]);
    }
}
