<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Products\Form;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Components;
use Tinoecom\Core\Models\InventoryHistory;

/**
 * @property Forms\Form $form
 */
class Inventory extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

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
                Components\Section::make(__('tinoecom::pages/products.inventory.title'))
                    ->description(__('tinoecom::pages/products.inventory.description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->label(__('tinoecom::forms.label.sku'))
                                    ->unique(config('tinoecom.models.product'), 'sku', ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('barcode')
                                    ->label(__('tinoecom::forms.label.barcode'))
                                    ->unique(config('tinoecom.models.product'), 'barcode', ignoreRecord: true)
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('security_stock')
                                    ->label(__('tinoecom::forms.label.safety_stock'))
                                    ->helperText(__('tinoecom::pages/products.safety_security_help_text'))
                                    ->numeric()
                                    ->default(0)
                                    ->rules(['integer', 'min:0']),
                            ]),
                    ]),
            ])
            ->statePath('data')
            ->model($this->product);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InventoryHistory::with(['inventory', 'stockable'])
                    ->where('stockable_id', $this->product->id)
                    ->where('stockable_type', 'product')
                    ->orderByDesc('created_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('tinoecom::words.date'))
                    ->since()
                    ->sortable(),

                Tables\Columns\TextColumn::make('event')
                    ->label(__('tinoecom::words.event')),

                Tables\Columns\TextColumn::make('inventory.name')
                    ->label(__('tinoecom::pages/settings/menu.location')),

                Tables\Columns\TextColumn::make('adjustment')
                    ->label(__('tinoecom::words.adjustment'))
                    ->color(function (InventoryHistory $record) {
                        if ($record->old_quantity > 0) {
                            return 'success';
                        }

                        if ($record->old_quantity <= 0) {
                            return 'danger';
                        }

                        return 'gray';
                    })
                    ->alignRight(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('tinoecom::pages/products.inventory.movement'))
                    ->color(fn (InventoryHistory $record) => $record->quantity <= 0 ? 'danger' : 'gray')
                    ->alignRight()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->label(__('tinoecom::words.total'))
                            ->numeric(),
                    ]),
            ])
            ->emptyStateIcon('untitledui-file-05')
            ->emptyStateDescription(__('tinoecom::pages/products.inventory.empty'))
            ->headerActions([
                Tables\Actions\Action::make('stock')
                    ->label('Add stock')
                    ->icon('untitledui-package')
                    ->color('gray')
                    ->modalWidth(MaxWidth::ExtraLarge)
                    ->form([
                        Forms\Components\Select::make('inventory')
                            ->label(__('tinoecom::pages/products.inventory_name'))
                            ->relationship('inventory', 'name')
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
                            ->where('stockable_id', $this->product->id)
                            ->where('stockable_type', 'product')
                            ->get()
                            ->sum('quantity');

                        $realTimeStock = $currentStock + $quantity;

                        if ($realTimeStock >= $currentStock) {
                            $this->product->mutateStock(
                                $inventoryId,
                                $quantity,
                                [
                                    'event' => __('tinoecom::pages/products.inventory.add'),
                                    'old_quantity' => $quantity,
                                ]
                            );
                        } else {
                            $this->product->decreaseStock(
                                $inventoryId,
                                $quantity,
                                [
                                    'event' => __('tinoecom::pages/products.inventory.remove'),
                                    'old_quantity' => $quantity,
                                ]
                            );
                        }

                        Notification::make()
                            ->title(__('Stock successfully Updated'))
                            ->success()
                            ->send();

                        $this->dispatch('updateInventory');
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('inventory')
                    ->relationship('inventory', 'name')
                    ->native(false),
            ])
            ->groups([
                Tables\Grouping\Group::make('inventory.name')
                    ->label(__('tinoecom::pages/settings/menu.location'))
                    ->collapsible(),
            ]);
    }

    public function store(): void
    {
        $this->product->update($this->form->getState());

        $this->dispatch('product.updated');

        Notification::make()
            ->title(__('tinoecom::pages/products.notifications.stock_update'))
            ->success()
            ->send();
    }

    #[On('updateInventory')]
    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.inventory');
    }
}
