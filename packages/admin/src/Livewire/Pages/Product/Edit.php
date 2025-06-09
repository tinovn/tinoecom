<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Product;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Tinoecom\Core\Events\Products\Deleted;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Edit extends AbstractPageComponent implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $product;

    #[Url(as: 'tab')]
    public string $activeTab = 'detail';

    public function mount(): void
    {
        $this->authorize('edit_products');

        $this->product = (new ProductRepository)->with('prices')->getById((int) $this->product);
    }

    public function deleteAction(): Action
    {
        return Action::make(__('tinoecom::forms.actions.delete'))
            ->requiresConfirmation()
            ->icon('untitledui-trash-03')
            ->modalIcon('untitledui-trash-03')
            ->authorize('delete_products', $this->product)
            ->color('danger')
            ->button()
            ->action(function (): void {
                event(new Deleted($this->product));

                $this->product->delete();

                Notification::make()
                    ->title(__('tinoecom::notifications.delete', ['item' => __('tinoecom::pages/products.single')]))
                    ->success()
                    ->send();

                $this->redirectRoute(name: 'tinoecom.products.index', navigate: true);
            });
    }

    #[On('product.updated')]
    public function render(): View
    {
        return view('tinoecom::livewire.pages.products.edit')
            ->title(__('tinoecom::forms.actions.edit_label', ['label' => $this->product->name]));
    }
}
