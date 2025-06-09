<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('tinoecom::components.layouts.base')]
final class Initialization extends Component
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.initialization')
            ->title(__('tinoecom::pages/onboarding.title'));
    }
}
