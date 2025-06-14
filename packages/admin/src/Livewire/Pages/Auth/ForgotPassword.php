<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('tinoecom::components.layouts.base')]
class ForgotPassword extends Component
{
    public string $email = '';

    public function sendResetPasswordLink(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        $response = $this->broker()->sendResetLink(['email' => $this->email]);

        if ($response === Password::RESET_LINK_SENT) {
            session()->flash('success', trans($response));

            return;
        }

        $this->addError('email', trans($response));
    }

    public function broker(): PasswordBroker
    {
        return Password::broker();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.auth.forgot-password')
            ->title(__('tinoecom::pages/auth.email.title'));
    }
}
