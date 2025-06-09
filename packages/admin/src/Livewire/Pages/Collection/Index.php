<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Collection;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Repositories\CollectionRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_collections');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                (new CollectionRepository)
                    ->query()
                    ->with('rules')
            )
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->circular()
                    ->defaultImageUrl(tinoecom_fallback_url())
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tinoecom::forms.label.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label(__('tinoecom::forms.label.type'))
                    ->formatStateUsing(fn ($record): string => $record->isAutomatic() ? __('tinoecom::pages/collections.automatic') : __('tinoecom::pages/collections.manual'))
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('id')
                    ->label(__('tinoecom::pages/collections.product_conditions'))
                    ->formatStateUsing(
                        fn ($record): string => $record->rules->isNotEmpty() ? ucfirst($record->firstRule()) : 'N/A'
                    ),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('tinoecom::forms.label.updated_at'))
                    ->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('tinoecom::forms.actions.edit'))
                    ->icon('untitledui-edit-04')
                    ->url(
                        fn ($record): string => route(
                            name: 'tinoecom.collections.edit',
                            parameters: ['collection' => $record]
                        ),
                    ),
                Tables\Actions\Action::make(__('tinoecom::forms.actions.delete'))
                    ->icon('untitledui-trash-03')
                    ->modalIcon('untitledui-trash-03')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->delete()),
            ]);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.collections.browse')
            ->title(__('tinoecom::pages/collections.menu'));
    }
}
