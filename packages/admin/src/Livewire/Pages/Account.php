<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages;

use Illuminate\Contracts\View\View;

class Account extends AbstractPageComponent
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.account')
            ->title(__('tinoecom::pages/auth.account.meta_title'));
    }
}
