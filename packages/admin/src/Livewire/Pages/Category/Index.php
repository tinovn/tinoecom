<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Category;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Tinoecom\Core\Repositories\CategoryRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;
use Tinoecom\Traits\HasAuthenticated;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use HasAuthenticated;
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_categories');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                (new CategoryRepository)
                    ->query()
                    ->with('parent')
                    ->latest()
            )
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->circular()
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tinoecom::forms.label.name'))
                    ->formatStateUsing(
                        fn ($record) => view('tinoecom::livewire.tables.cells.categories.name', [
                            'category' => $record,
                        ])
                    )
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('tinoecom::forms.label.slug'))
                    ->description(__('tinoecom::words.slug_description'))
                    ->badge()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_enabled')
                    ->label(__('tinoecom::forms.label.visibility'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('tinoecom::forms.label.updated_at'))
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_enabled'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('tinoecom::forms.actions.edit'))
                    ->icon('untitledui-edit-04')
                    ->action(
                        fn ($record) => $this->dispatch(
                            'openPanel',
                            component: 'tinoecom-slide-overs.category-form',
                            arguments: ['categoryId' => $record->id]
                        )
                    )
                    ->visible($this->getUser()->can('edit_categories')),
            ])
            ->groupedBulkActions([
                Tables\Actions\BulkAction::make('enabled')
                    ->label(__('tinoecom::forms.actions.enable'))
                    ->icon('untitledui-check-verified')
                    ->action(function (Collection $records): void {
                        $records->each->updateStatus(); // @phpstan-ignore-line

                        Notification::make()
                            ->title(
                                __('tinoecom::notifications.enabled', [
                                    'item' => __('tinoecom::pages/categories.single'),
                                ])
                            )
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\BulkAction::make('disabled')
                    ->label(__('tinoecom::forms.actions.disable'))
                    ->icon('untitledui-slash-circle-01')
                    ->action(function (Collection $records): void {
                        $records->each->updateStatus(status: false); // @phpstan-ignore-line

                        Notification::make()
                            ->title(
                                __('tinoecom::notifications.disabled', [
                                    'item' => __('tinoecom::pages/categories.single'),
                                ])
                            )
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
                Tables\Actions\DeleteBulkAction::make()
                    ->label(__('tinoecom::forms.actions.delete'))
                    ->icon('untitledui-trash-03')
                    ->requiresConfirmation()
                    ->action(function (Collection $records): void {
                        $records->each->delete();

                        Notification::make()
                            ->title(
                                __('tinoecom::notifications.delete', [
                                    'item' => __('tinoecom::pages/categories.single'),
                                ])
                            )
                            ->success()
                            ->send();
                    })
                    ->visible($this->getUser()->can('delete_categories'))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->persistFiltersInSession()
            ->headerActions([
                Tables\Actions\Action::make('reorder')
                    ->label(__('tinoecom::words.reorder'))
                    ->icon('untitledui-switch-vertical')
                    ->color('gray')
                    ->action(
                        fn ($record) => $this->dispatch(
                            'openPanel',
                            component: 'tinoecom-slide-overs.re-order-categories'
                        )
                    ),
            ]);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.category.index')
            ->title(__('tinoecom::pages/categories.menu'));
    }
}
