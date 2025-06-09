<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Brand;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Tinoecom\Core\Repositories\BrandRepository;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_brands');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query((new BrandRepository)->query())
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('Logo')
                    ->collection(config('tinoecom.media.storage.thumbnail_collection'))
                    ->circular()
                    ->grow(false),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('tinoecom::forms.label.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('website')
                    ->label(__('tinoecom::forms.label.website'))
                    ->formatStateUsing(fn (string $state): View => view(
                        'tinoecom::livewire.tables.cells.brands.site',
                        ['state' => $state],
                    )),
                Tables\Columns\IconColumn::make('is_enabled')
                    ->label(__('tinoecom::forms.label.visibility'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('tinoecom::forms.label.updated_at'))
                    ->date()
                    ->sortable(),
            ])
            ->reorderable('position')
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('tinoecom::forms.actions.edit'))
                    ->icon('untitledui-edit-04')
                    ->action(
                        fn ($record) => $this->dispatch(
                            'openPanel',
                            component: 'tinoecom-slide-overs.brand-form',
                            arguments: ['brandId' => $record->id]
                        )
                    )
                    ->visible(Tinoecom::auth()->user()->can('edit_brands')),
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
                                    'item' => __('tinoecom::pages/brands.single'),
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
                            ->title(__('tinoecom::components.tables.status.updated'))
                            ->body(
                                __('tinoecom::notifications.disabled', [
                                    'item' => __('tinoecom::pages/brands.single'),
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
                                    'item' => __('tinoecom::pages/brands.single'),
                                ])
                            )
                            ->success()
                            ->send();
                    })
                    ->deselectRecordsAfterCompletion(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_enabled'),
            ])
            ->persistFiltersInSession();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.brand.index')
            ->title(__('tinoecom::pages/brands.menu'));
    }
}
