<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Components\Account;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Tinoecom\Actions\Auth\DisableTwoFactorAuthentication;
use Tinoecom\Actions\Auth\EnableTwoFactorAuthentication;
use Tinoecom\Actions\Auth\GenerateNewRecoveryCodes;
use Tinoecom\Traits\ConfirmsPasswords;

/**
 * @property Authenticatable $user
 */
class TwoFactor extends Component
{
    use ConfirmsPasswords;

    public bool $showingQrCode = false;

    public bool $showingRecoveryCodes = false;

    #[On('enableTwoFactorAuthentication')]
    public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable): void
    {
        if (config('tinoecom.auth.2fa_enabled')) {
            $this->ensurePasswordIsConfirmed();
        }

        $enable($this->user);

        $this->showingQrCode = true;
        $this->showingRecoveryCodes = true;

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.two_factor_enabled'))
            ->success()
            ->send();
    }

    #[On('showRecoveryCodes')]
    public function showRecoveryCodes(): void
    {
        if (config('tinoecom.auth.2fa_enabled')) {
            $this->ensurePasswordIsConfirmed();
        }

        $this->showingRecoveryCodes = true;
    }

    #[On('regenerateRecoveryCodes')]
    public function regenerateRecoveryCodes(GenerateNewRecoveryCodes $generate): void
    {
        if (config('tinoecom.auth.2fa_enabled')) {
            $this->ensurePasswordIsConfirmed();
        }

        $generate($this->user);

        $this->showingRecoveryCodes = true;

        Notification::make()
            ->title(__('tinoecom::notifications.users_roles.two_factor_generate'))
            ->success()
            ->send();
    }

    #[On('disableTwoFactorAuthentication')]
    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable): void
    {
        if (config('tinoecom.auth.2fa_enabled')) {
            $this->ensurePasswordIsConfirmed();
        }

        $disable($this->user);

        Notification::make()
            ->body(__('tinoecom::notifications.users_roles.two_factor_disabled'))
            ->success()
            ->send();
    }

    #[Computed]
    public function user(): Authenticatable
    {
        return tinoecom()->auth()->user();
    }

    #[Computed]
    public function enabled(): bool
    {
        return ! empty($this->user->two_factor_secret);
    }

    public function render(): View
    {
        return view('tinoecom::livewire.components.account.two-factor');
    }
}
