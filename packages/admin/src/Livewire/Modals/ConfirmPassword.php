<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Tinoecom\Actions\Auth\ConfirmPassword as ConfirmPasswordAction;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Livewire\Components\ModalComponent;

class ConfirmPassword extends ModalComponent
{
    public string $confirmablePassword = '';

    public string $action = '';

    public function mount(string $action): void
    {
        $this->action = $action;
    }

    public function confirmPassword(): void
    {
        if (! app(ConfirmPasswordAction::class)(Tinoecom::auth(), Tinoecom::auth()->user(), $this->confirmablePassword)) {
            throw ValidationException::withMessages([
                'confirmable_password' => [__('tinoecom::notifications.auth.password')],
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->stopConfirmingPassword();

        $this->dispatch($this->action);

        $this->closeModal();
    }

    public function stopConfirmingPassword(): void
    {
        $this->reset('confirmablePassword');
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.confirm-password');
    }
}
