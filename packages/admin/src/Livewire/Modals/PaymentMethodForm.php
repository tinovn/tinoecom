<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Tinoecom\Core\Models\PaymentMethod;
use Tinoecom\Livewire\Components\ModalComponent;

/**
 * @property Form $form
 */
class PaymentMethodForm extends ModalComponent implements HasForms
{
    use InteractsWithForms;

    public ?int $paymentId = null;

    public ?array $data = [];

    public function mount(?int $paymentId = null): void
    {
        $this->paymentId = $paymentId;

        $this->form->fill(PaymentMethod::query()->find($paymentId)?->toArray());
    }

    public static function modalMaxWidth(): string
    {
        return '2xl';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\FileUpload::make('logo')
                    ->label(__('tinoecom::forms.label.provider_logo'))
                    ->avatar()
                    ->image()
                    ->maxSize(1024)
                    ->disk(config('tinoecom.media.storage.disk_name'))
                    ->columnSpan('full'),
                Components\TextInput::make('title')
                    ->label(__('tinoecom::forms.label.payment_method'))
                    ->placeholder('NotchPay')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', $state)),
                Components\Hidden::make('slug'),
                Components\TextInput::make('link_url')
                    ->label(__('tinoecom::forms.label.payment_doc'))
                    ->placeholder('https://notchpay.co')
                    ->url(),
                Components\Textarea::make('description')
                    ->label(__('tinoecom::forms.label.additional_details'))
                    ->helperText(__('tinoecom::pages/settings/payments.help_text'))
                    ->rows(3)
                    ->columnSpan('full'),
                Components\Textarea::make('instructions')
                    ->label(__('tinoecom::forms.label.payment_instruction'))
                    ->helperText(__('tinoecom::pages/settings/payments.instruction'))
                    ->rows(3)
                    ->columnSpan('full'),
            ])
            ->columns()
            ->statePath('data');
    }

    public function save(): void
    {
        PaymentMethod::query()->updateOrCreate(
            attributes: ['id' => $this->paymentId],
            values: $this->form->getState()
        );

        Notification::make()
            ->title(__('tinoecom::notifications.payment.add'))
            ->success()
            ->send();

        $this->dispatch('onPaymentMethodAdded');

        $this->reset();

        $this->closeModal();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.payment-method-form');
    }
}
