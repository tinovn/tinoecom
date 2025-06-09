<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Products;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Core\Models\Inventory;
use Tinoecom\Core\Models\InventoryHistory;

class VariantStock extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public $variant;

    public function stockAction(): Action
    {
        return Action::make('stock')
            ->label(__('tinoecom::forms.actions.update'))
            ->color('gray')
            ->icon('untitledui-package')
            ->modalHeading(__('tinoecom::pages/products.modals.variants.title'))
            ->modalWidth(MaxWidth::ExtraLarge)
            ->form([
                Forms\Components\Select::make('inventory')
                    ->label(__('tinoecom::pages/products.inventory_name'))
                    ->options(Inventory::query()->pluck('name', 'id'))
                    ->native(false)
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label(__('tinoecom::forms.label.quantity'))
                    ->placeholder('-10 or -5 or 50, etc')
                    ->numeric()
                    ->required(),
            ])
            ->action(function (array $data): void {
                $inventoryId = (int) $data['inventory'];
                $quantity = (int) $data['quantity'];

                $currentStock = InventoryHistory::query()
                    ->where('inventory_id', $inventoryId)
                    ->where('stockable_id', $this->variant->id)
                    ->where('stockable_type', 'product')
                    ->get()
                    ->sum('quantity');

                $realTimeStock = $currentStock + $quantity;

                if ($realTimeStock >= $currentStock) {
                    $this->variant->mutateStock(
                        $inventoryId,
                        $quantity,
                        [
                            'event' => __('tinoecom::pages/products.inventory.add'),
                            'old_quantity' => $quantity,
                        ]
                    );
                } else {
                    $this->variant->decreaseStock(
                        $inventoryId,
                        $quantity,
                        [
                            'event' => __('tinoecom::pages/products.inventory.remove'),
                            'old_quantity' => $quantity,
                        ]
                    );
                }

                Notification::make()
                    ->title(__('tinoecom::notifications.update', ['item' => __('tinoecom::words.stock')]))
                    ->success()
                    ->send();

                $this->dispatch('$refresh');
            });
    }

    // #[On('updateVariantInventory')]
    public function render(): View
    {
        return view('tinoecom::livewire.components.products.variant-stock', [
            'inventories' => Inventory::query()->get(),
        ]);
    }
}
