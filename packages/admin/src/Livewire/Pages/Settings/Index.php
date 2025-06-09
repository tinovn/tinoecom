<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings;

use Illuminate\Contracts\View\View;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.index')
            ->title(__('tinoecom::pages/settings/global.menu'));
    }
}
