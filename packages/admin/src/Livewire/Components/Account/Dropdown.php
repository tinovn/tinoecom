<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Account;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Traits\HasAuthenticated;

class Dropdown extends Component
{
    use HasAuthenticated;

    public $user;

    public function mount(): void
    {
        $this->user = $this->getUser();
    }

    #[On('updated-profile')]
    public function updatedProfile(): void
    {
        $this->user = $this->getUser();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.account.dropdown');
    }
}
