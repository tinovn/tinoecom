<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Products\Form;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Tinoecom\Actions\Store\Product\DetachAttributesToProductAction;
use Tinoecom\Components\Tables\IconColumn;
use Tinoecom\Core\Models\AttributeProduct;

#[Lazy]
class Attributes extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public $product;

    public function placeholder(): View
    {
        return view('tinoecom::components.skeleton.products.section');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AttributeProduct::with(['attribute', 'value', 'value.attribute'])
                    ->where('product_id', $this->product->id)
            )
            ->columns([
                IconColumn::make('attribute.icon')
                    ->label(__('tinoecom::forms.label.icon')),
                Tables\Columns\TextColumn::make('attribute.name')
                    ->label(__('tinoecom::forms.label.name')),
                Tables\Columns\ViewColumn::make('attribute_value_id')
                    ->label(__('tinoecom::forms.label.value'))
                    ->view('tinoecom::livewire.tables.cells.products.attribute-value'),
                Tables\Columns\TextColumn::make('attribute_custom_value')
                    ->label(__('tinoecom::forms.label.attribute_custom_value'))
                    ->html()
                    ->limit(150),
            ])
            ->groups([
                Tables\Grouping\Group::make('attribute_id')
                    ->label(__('tinoecom::forms.label.attribute'))
                    ->getTitleFromRecordUsing(fn ($record): string => $record->attribute->name),
            ])
            ->defaultGroup('attribute_id')
            ->headerActions([
                Tables\Actions\Action::make('choose')
                    ->label(__('tinoecom::pages/products.attributes.choose'))
                    ->action(
                        fn () => $this->dispatch(
                            'openPanel',
                            component: 'tinoecom-slide-overs.choose-product-attributes',
                            arguments: ['productId' => $this->product->id]
                        )
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('delete')
                    ->icon('untitledui-trash-03')
                    ->label(__('tinoecom::forms.actions.delete'))
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $this->authorize('delete_attributes', $record);

                        app()->call(DetachAttributesToProductAction::class, [
                            'attributeProduct' => $record,
                            'product' => $this->product,
                        ]);

                        $this->dispatch('product.updated');
                    })
                    ->successNotificationTitle(__('tinoecom::pages/products.attributes.session.delete_message')),
            ])
            ->emptyStateHeading(__('tinoecom::pages/products.attributes.empty_title'))
            ->emptyStateDescription(__('tinoecom::pages/products.attributes.empty_values'))
            ->emptyStateIcon('untitledui-puzzle-piece');
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.products.forms.attributes');
    }
}
