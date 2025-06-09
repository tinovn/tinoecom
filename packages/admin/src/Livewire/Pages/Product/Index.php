<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Product;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Enum\ProductType;
use Tinoecom\Core\Events\Products\Deleted;
use Tinoecom\Core\Repositories\ProductRepository;
use Tinoecom\Feature;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_products');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                (new ProductRepository)
                    ->query()
                    ->with(['brand', 'variants'])
                    ->withCount(['variants'])
                    ->latest()
            )
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->label(__('tinoecom::forms.label.thumbnail'))
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tinoecom::forms.label.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('tinoecom::forms.label.type'))
                    ->badge(),
                Tables\Columns\TextColumn::make('sku')
                    ->label(__('tinoecom::layout.tables.sku'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label(__('tinoecom::forms.label.brand'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->hidden(! Feature::enabled('brand')),
                Tables\Columns\ViewColumn::make('stock')
                    ->label(__('tinoecom::layout.tables.stock'))
                    ->view('tinoecom::livewire.tables.cells.products.stock')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label(__('tinoecom::forms.label.visibility'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('tinoecom::forms.label.published_at'))
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('edit')
                        ->label(__('tinoecom::forms.actions.edit'))
                        ->icon('untitledui-edit-04')
                        ->color('primary')
                        ->action(fn ($record) => $this->redirectRoute(
                            name: 'tinoecom.products.edit',
                            parameters: ['product' => $record]
                        )),
                    Tables\Actions\Action::make(__('tinoecom::forms.actions.delete'))
                        ->icon('untitledui-trash-03')
                        ->modalIcon('untitledui-trash-03')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($record): void {
                            event(new Deleted($record));

                            $record->delete();
                        }),
                ])
                    ->tooltip('Actions'),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        QueryBuilder\Constraints\TextConstraint::make('name'),
                        QueryBuilder\Constraints\SelectConstraint::make('type')
                            ->options(ProductType::class)
                            ->multiple(),
                        QueryBuilder\Constraints\BooleanConstraint::make('is_visible')
                            ->label(__('tinoecom::forms.label.availability')),
                        QueryBuilder\Constraints\DateConstraint::make('published_at'),
                    ])
                    ->constraintPickerColumns(),
            ])
            ->deferFilters()
            ->filtersFormWidth(MaxWidth::Large);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.products.index')
            ->title(__('tinoecom::pages/products.menu'));
    }
}
