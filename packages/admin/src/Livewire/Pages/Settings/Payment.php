<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Settings;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Core\Models\PaymentMethod;

#[Layout('tinoecom::components.layouts.setting')]
class Payment extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public ?array $tabs = [];

    public function mount(): void
    {
        $this->tabs = collect(['general'])->toArray();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(PaymentMethod::query()->latest())
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label(__('tinoecom::forms.label.logo'))
                    ->circular()
                    ->disk(config('tinoecom.media.storage.disk_name'))
                    ->defaultImageUrl(tinoecom_fallback_url()),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('tinoecom::forms.label.title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_url')
                    ->copyable()
                    ->label(__('tinoecom::forms.label.website')),
                Tables\Columns\ToggleColumn::make('is_enabled')
                    ->label(__('tinoecom::forms.label.status')),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('tinoecom::forms.label.updated_at'))
                    ->date(),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label(__('tinoecom::forms.actions.edit'))
                    ->icon('untitledui-edit-04')
                    ->action(fn (PaymentMethod $record) => $this->dispatch(
                        'openModal',
                        component: 'tinoecom-modals.payment-method-form',
                        arguments: ['paymentId' => $record->id],
                    )),
                Tables\Actions\DeleteAction::make('delete')
                    ->label(__('tinoecom::forms.actions.delete'))
                    ->icon('untitledui-trash-03'),
            ])
            ->emptyStateIcon('untitledui-credit-card-02')
            ->emptyStateDescription(__('tinoecom::pages/settings/payments.no_method'));
    }

    #[On('onPaymentMethodAdded')]
    public function render(): View
    {
        return view('tinoecom::livewire.pages.settings.payment');
    }
}
