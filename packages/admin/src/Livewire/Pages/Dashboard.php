<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages;

use Illuminate\Contracts\View\View;

class Dashboard extends AbstractPageComponent
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.dashboard')
            ->title(__('tinoecom::pages/dashboard.menu'));
    }
}
