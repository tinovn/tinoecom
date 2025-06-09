<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Products\Form;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Tinoecom\Components;

/**
 * @property Forms\Form $form
 */
class Shipping extends Component implements HasForms
{
    use InteractsWithForms;

    public $product;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->product->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make(__('tinoecom::pages/products.shipping.package_dimension'))
                    ->description(__('tinoecom::pages/products.shipping.package_dimension_description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema(Components\Form\ShippingField::make()),
                    ]),
            ])
            ->statePath('data')
            ->model($this->product);
    }

    public function store(): void
    {
        $this->product->update($this->form->getState());

        $this->dispatch('product.updated');

        Notification::make()
            ->title(__('tinoecom::pages/products.notifications.shipping_update'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.shipping');
    }
}
