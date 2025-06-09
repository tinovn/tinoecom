<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Customers;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Tinoecom\Core\Models\User;

class Profile extends Component
{
    /**
     * @var User
     */
    public $customer;

    public function render(): View
    {
        return view('tinoecom::livewire.components.customers.profile');
    }
}
