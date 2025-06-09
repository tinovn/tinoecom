<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Order;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\Order;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_orders');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()
                    ->with([
                        'customer',
                        'items',
                        'zone',
                        'items.product',
                        'items.product.media',
                    ])
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->label('#')
                    ->searchable()
                    ->extraAttributes(['class' => 'uppercase'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('tinoecom::words.date'))
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('tinoecom::forms.label.status'))
                    ->badge(),
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->label(__('tinoecom::words.customer'))
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (Order $record): View => view(
                        'tinoecom::livewire.tables.cells.orders.customer',
                        ['order' => $record]
                    ))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('id')
                    ->label(__('tinoecom::words.purchased'))
                    ->formatStateUsing(fn (Order $record): View => view(
                        'tinoecom::livewire.tables.cells.orders.purchased',
                        ['order' => $record]
                    )),
                Tables\Columns\TextColumn::make('currency_code')
                    ->label(__('tinoecom::forms.label.price_amount'))
                    ->formatStateUsing(
                        fn ($state, Order $record): string => tinoecom_money_format(amount: $record->total(), currency: $state)
                    ),
                Tables\Columns\TextColumn::make('zone.name')
                    ->label(__('tinoecom::pages/settings/zones.single'))
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__('tinoecom::words.details'))
                    ->url(
                        fn (Order $record): string => route(
                            name: 'tinoecom.orders.detail',
                            parameters: ['order' => $record]
                        ),
                    ),
            ]);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.orders.index')
            ->title(__('tinoecom::pages/orders.menu'));
    }
}
