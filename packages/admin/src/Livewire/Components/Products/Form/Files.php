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
use Tinoecom\Core\Models\Product;

/**
 * @property Forms\Form $form
 */
class Files extends Component implements HasForms
{
    use InteractsWithForms;

    public Product $product;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->product->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\SpatieMediaLibraryFileUpload::make('files')
                    ->collection('files')
                    ->label(__('tinoecom::words.files'))
                    ->helperText(__('tinoecom::pages/products.files_helpText'))
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
        $this->product->update($this->form->getState());

        $this->dispatch('product.updated');

        Notification::make()
            ->body(__('tinoecom::pages/products.notifications.files_update'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.files');
    }
}
