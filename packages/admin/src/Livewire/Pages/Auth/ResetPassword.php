<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Pages\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Tinoecom\Facades\Tinoecom;

#[Layout('tinoecom::components.layouts.base')]
class ResetPassword extends Component
{
    #[Locked]
    public ?string $token = null;

    public string $email = '';

    public string $password = '';

    public function mount(?string $token = null): void
    {
        $this->email = request()->query('email', '');
        $this->token = $token;
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => 'required',
            'email' => ['required', 'email'],
            'password' => [
                'required',
                PasswordRule::min(8)
                    ->numbers()
                    ->symbols()
                    ->mixedCase(),
            ],
        ]);

        $response = $this->broker()->reset(
            credentials: [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
            ],
            callback: function ($user, string $password): void {
                $user->password = Hash::make($password);
                $user->save();

                Tinoecom::auth()->login($user);
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            $this->redirectRoute('tinoecom.dashboard');
        }

        $this->addError('email', trans($response));
    }

    public function broker(): PasswordBroker
    {
        return Password::broker();
    }

    public function render(): View
    {
        return view('tinoecom::livewire.pages.auth.reset-password')
            ->title(__('tinoecom::pages/auth.reset.title'));
    }
}
