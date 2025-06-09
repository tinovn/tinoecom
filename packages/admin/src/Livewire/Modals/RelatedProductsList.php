<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Livewire\Components\ModalComponent;

class RelatedProductsList extends ModalComponent
{
    public $product;

    public string $search = '';

    #[Locked]
    public array $exceptProductIds = [];

    public array $selectedProducts = [];

    public function mount(int $productId, array $ids = []): void
    {
        $this->product = (new ProductRepository)->getById($productId);
        $this->exceptProductIds = $ids;
    }

    #[Computed]
    public function products(): Collection
    {
        return (new ProductRepository) // @phpstan-ignore-line
            ->query()
            ->where(
                column: 'name',
                operator: 'like',
                value: '%' . $this->search . '%'
            )
            ->get(['name', 'id'])
            ->except($this->exceptProductIds);
    }

    public function addSelectedProducts(): void
    {
        $currentProducts = $this->product->relatedProducts->pluck('id')->toArray();

        $this->product->relatedProducts()->sync(array_merge($this->selectedProducts, $currentProducts));

        Notification::make()
            ->title(__('tinoecom::layout.status.added'))
            ->body(__('tinoecom::pages/products.notifications.related_added'))
            ->success()
            ->send();

        $this->redirect(
            route('tinoecom.products.edit', ['product' => $this->product, 'tab' => 'related']),
            navigate: true
        );
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.related-products-list');
    }
}
