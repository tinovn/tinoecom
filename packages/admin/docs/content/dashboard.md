# Dashboard

The dashboard is a user-customizable screen. One of Tinoecom's main goals is to enable stores to easily customize the modules.

## Overview

When you log into the control panel, you will be taken to the dashboard — a customizable screen dispatch with a Livewire component!

Laravel Tinoecom is a free open-source e-commerce application based on the [TALL Stack](https://tallstack.dev) and aims to build an e-commerce administration using only [Livewire](https://laravel-livewire.com) components.

The navigation at the left contains the available panels for everyday use:

<div class="screenshot">
    <img src="/screenshots/{{version}}/dashboard.png" alt="Tinoecom Global Set Example">
    <div class="caption">The dashboard and the Getting Started panel</div>
</div>

Clicking on each icon will open the panel or shows a list of available panels.

## Components

The component that displays the dashboard is quite simple, so you can easily replace it to put your own.

The component used is `Tinoecom\Livewire\Pages\Dashboard` and can also be found in the components file `config/tinoecom/components/dashboard.php`.

```php
namespace Tinoecom\Livewire\Pages;

use Illuminate\Contracts\View\View;

class Dashboard extends AbstractPageComponent
{
    public function render(): View
    {
        return view('tinoecom::livewire.pages.dashboard')
            ->layout('tinoecom::components.layouts.app', [
                'title' => __('tinoecom::layout.sidebar.dashboard'),
            ]);
    }
}
```
