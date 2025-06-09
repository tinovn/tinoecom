<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Collection;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Core\Models\Collection;

/**
 * @property-read array<int, array-key> $productsIds
 */
class CollectionProducts extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Collection $collection;

    /**
     * @return array<int, array-key>
     */
    #[Computed]
    public function productsIds(): array
    {
        return $this->collection->products->modelKeys(); // @phpstan-ignore-line
    }

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): BelongsToMany => $this->collection->products())
            ->inverseRelationship('collections')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->label(__('tinoecom::forms.label.thumbnail'))
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->circular()
                    ->defaultImageUrl(tinoecom_fallback_url()),
                Tables\Columns\TextColumn::make('name'),
            ])
            ->actions([
                Tables\Actions\Action::make(__('tinoecom::forms.actions.delete'))
                    ->icon('untitledui-trash-03')
                    ->iconButton()
                    ->modalIcon('untitledui-trash-03')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record): void {
                        $this->collection->products()->detach([$record->id]);

                        $this->dispatch('onProductsAddInCollection');

                        Notification::make()
                            ->title(__('tinoecom::pages/collections.remove_product'))
                            ->success()
                            ->send();
                    }),
            ])
            ->headerActions([
                Tables\Actions\Action::make('rules')
                    ->label(__('tinoecom::pages/collections.conditions.title'))
                    ->icon('untitledui-ruler')
                    ->button()
                    ->color('gray')
                    ->action(fn () => $this->dispatch(
                        'openPanel',
                        component: 'tinoecom-slide-overs.collection-rules',
                        arguments: ['collection' => $this->collection]
                    ))
                    ->visible($this->collection->isAutomatic()),

                Tables\Actions\Action::make('products')
                    ->label(__('tinoecom::forms.label.browse'))
                    ->icon('untitledui-book-open')
                    ->button()
                    ->color('gray')
                    ->action(fn () => $this->dispatch(
                        'openModal',
                        component: 'tinoecom-modals.products-list',
                        arguments: [
                            'collectionId' => $this->collection->id,
                            'exceptProductIds' => $this->productsIds,
                        ]
                    ))
                    ->visible($this->collection->isManual()),
            ])
            ->emptyStateIcon('untitledui-book-open')
            ->emptyStateDescription(__('tinoecom::pages/collections.empty_collections'));
    }

    #[On('onProductsAddInCollection')]
    public function render(): View
    {
        return view('tinoecom::livewire.components.collections.products');
    }
}
