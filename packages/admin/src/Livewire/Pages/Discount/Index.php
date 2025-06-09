<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Discount;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Tinoecom\Core\Enum\DiscountApplyTo;
use Tinoecom\Core\Enum\DiscountEligibility;
use Tinoecom\Core\Models\Discount;
use Tinoecom\Livewire\Pages\AbstractPageComponent;
use Tinoecom\Traits\HasAuthenticated;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use HasAuthenticated;
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_discounts');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Discount::with('zone', 'zone.currency')->latest())
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label(__('tinoecom::forms.label.code'))
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('value')
                    ->label(__('tinoecom::words.amount'))
                    ->toggleable()
                    ->view('tinoecom::livewire.tables.cells.discounts.amount'),
                Tables\Columns\TextColumn::make('apply_to')
                    ->label(__('tinoecom::pages/discounts.applies_to'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->color('gray')
                    ->badge(),
                Tables\Columns\TextColumn::make('eligibility')
                    ->label(__('tinoecom::pages/discounts.customer_eligibility'))
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->color('gray')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('tinoecom::forms.label.status'))
                    ->boolean()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('start_at')
                    ->label(__('tinoecom::words.date'))
                    ->toggleable()
                    ->view('tinoecom::livewire.tables.cells.discounts.date'),
                Tables\Columns\TextColumn::make('usage_limit')
                    ->label(__('tinoecom::pages/discounts.usage_limits'))
                    ->alignRight()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_use')
                    ->label(__('tinoecom::pages/discounts.total_use'))
                    ->alignRight()
                    ->sortable(),
                Tables\Columns\TextColumn::make('zone.name')
                    ->label(__('tinoecom::pages/settings/zones.single'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('tinoecom::forms.actions.edit'))
                    ->icon('untitledui-edit-04')
                    ->action(
                        fn (Discount $record) => $this->dispatch(
                            'openPanel',
                            component: 'tinoecom-slide-overs.discount-form',
                            arguments: ['discountId' => $record->id]
                        )
                    )
                    ->visible($this->getUser()->can('edit_discounts')),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label(__('tinoecom::forms.actions.delete'))
                    ->icon('untitledui-trash-03')
                    ->requiresConfirmation()
                    ->action(function (Collection $records): void {
                        $records->each->delete();

                        Notification::make()
                            ->title(
                                __('tinoecom::notifications.delete', [
                                    'item' => __('tinoecom::pages/discounts.single'),
                                ])
                            )
                            ->success()
                            ->send();
                    })
                    ->visible($this->getUser()->can('delete_discounts'))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\SelectFilter::make('apply_to')
                    ->options(DiscountApplyTo::options()),
                Tables\Filters\SelectFilter::make('eligibility')
                    ->options(DiscountEligibility::options()),
                Tables\Filters\Filter::make('start_at')
                    ->label(__('tinoecom::pages/discounts.start_date'))
                    ->form([
                        DatePicker::make('start_at_from')
                            ->native(false),
                        DatePicker::make('start_at_until')
                            ->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['start_at_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('start_at', '>=', $date),
                        )
                        ->when(
                            $data['start_at_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('start_at', '<=', $date),
                        )),
            ])
            ->emptyStateIcon('heroicon-o-gift')
            ->emptyStateHeading(__('tinoecom::pages/discounts.empty_message'));
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.discounts.index')
            ->title(__('tinoecom::pages/discounts.menu'));
    }
}
