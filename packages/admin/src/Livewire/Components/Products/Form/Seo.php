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
class Seo extends Component implements HasForms
{
    use InteractsWithForms;

    public $product;

    public ?array $data = [];

    public function mount($product): void
    {
        $this->product = $product;

        $this->form->fill($this->product->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema(Components\Form\SeoField::make()),

                Forms\Components\KeyValue::make('metadata')
                    ->reorderable(),
            ])
            ->statePath('data')
            ->model($this->product);
    }

    public function store(): void
    {
        $this->product->update($this->form->getState());

        $this->dispatch('product.updated');

        Notification::make()
            ->body(__('tinoecom::pages/products.notifications.seo_update'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.seo');
    }
}
