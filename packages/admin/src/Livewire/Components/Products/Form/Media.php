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

/**
 * @property Forms\Form $form
 */
class Media extends Component implements HasForms
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
                Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->label(__('tinoecom::forms.label.thumbnail'))
                    ->helperText(__('tinoecom::pages/products.thumbnail_helpText'))
                    ->image()
                    ->maxSize(config('tinoecom.media.max_size.thumbnail'))
                    ->columnSpan(['lg' => 1]),
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->collection(config('tinoecom.media.storage.collection_name'))
                    ->label(__('tinoecom::words.images'))
                    ->helperText(__('tinoecom::pages/products.images_helpText'))
                    ->multiple()
                    ->panelLayout('grid')
                    ->maxSize(config('tinoecom.media.max_size.images'))
                    ->columnSpan(['lg' => 2]),
            ])
            ->columns(3)
            ->statePath('data')
            ->model($this->product);
    }

    public function store(): void
    {
        $this->validate();

        $this->product->update($this->form->getState());

        $this->dispatch('product.updated');

        Notification::make()
            ->body(__('tinoecom::pages/products.notifications.media_update'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.media');
    }
}
