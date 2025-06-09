<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Account;

use Filament\Forms\Components;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Tinoecom\Components\Section;
use Tinoecom\Core\Models\User;

/**
 * @property Form $form
 */
class Password extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('tinoecom::pages/auth.account.password_title'))
                    ->description(__('tinoecom::pages/auth.account.password_description'))
                    ->aside()
                    ->compact()
                    ->schema([
                        Components\TextInput::make('current_password')
                            ->label(__('tinoecom::forms.label.current_password'))
                            ->password()
                            ->currentPassword()
                            ->revealable()
                            ->required(),
                        Components\TextInput::make('password')
                            ->label(__('tinoecom::forms.label.new_password'))
                            ->helperText(__('tinoecom::pages/auth.account.password_helper_validation'))
                            ->password()
                            ->revealable()
                            ->required()
                            ->confirmed(),
                        Components\TextInput::make('password_confirmation')
                            ->label(__('tinoecom::forms.label.confirm_password'))
                            ->password()
                            ->revealable()
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->danger()
            ->send();
    }

    public function save(): void
    {
        /** @var User $user */
        $user = tinoecom()->auth()->user();

        $user->update(['password' => Hash::make(value: $this->form->getState()['password'])]);

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.password_changed'))
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.account.password');
    }
}
