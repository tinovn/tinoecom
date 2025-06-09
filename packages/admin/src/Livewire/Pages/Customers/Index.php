<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Customers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Tinoecom\Core\Enum\OrderStatus;
use Tinoecom\Core\Repositories\UserRepository;
use Tinoecom\Livewire\Pages\AbstractPageComponent;

class Index extends AbstractPageComponent implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function mount(): void
    {
        $this->authorize('browse_customers');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                (new UserRepository)
                    ->query()
                    ->with(['addresses', 'addresses.country'])
                    ->scopes('customers')
                    ->latest()
            )
            ->columns([
                Tables\Columns\ViewColumn::make('first_name')
                    ->label(__('tinoecom::forms.label.full_name'))
                    ->view('tinoecom::livewire.tables.cells.customers.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('email')
                    ->label(__('tinoecom::forms.label.email'))
                    ->view('tinoecom::livewire.tables.cells.customers.email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->label(__('tinoecom::forms.label.country'))
                    ->getStateUsing(
                        fn ($record): ?string => $record->addresses->first()?->country?->name
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts([
                        'orders' => fn (Builder $query) => $query->where('status', OrderStatus::Paid()),
                    ])
                    ->label(__('tinoecom::pages/customers.orders.placed')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('tinoecom::forms.label.registered_at'))
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label(__('tinoecom::forms.actions.view'))
                    ->icon('untitledui-eye')
                    ->action(fn ($record) => $this->redirectRoute(
                        name: 'tinoecom.customers.show',
                        parameters: ['user' => $record],
                        navigate: true
                    )),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label(__('tinoecom::forms.label.email_verified'))
                    ->nullable(),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->native(false),
                        DatePicker::make('created_until')
                            ->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        )),
            ])
            ->persistFiltersInSession();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.customers.index')
            ->title(__('tinoecom::pages/customers.menu'));
    }
}
