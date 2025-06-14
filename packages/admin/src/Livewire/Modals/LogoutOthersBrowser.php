<?php

declare(strict_types=1);

namespace Tinoecom\Livewire\Modals;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tinoecom\Livewire\Components\ModalComponent;

class LogoutOthersBrowser extends ModalComponent
{
    public string $password = '';

    protected array $rules = [
        'password' => 'required',
    ];

    public function logoutOtherBrowserSessions(StatefulGuard $guard): void
    {
        $this->resetErrorBag();

        // @phpstan-ignore-next-line
        if (! Hash::check($this->password, auth()->user()->password)) {
            throw ValidationException::withMessages(['password' => [__('tinoecom::notifications.auth.password')]]);
        }

        $guard->logoutOtherDevices($this->password); // @phpstan-ignore-line

        $this->deleteOtherSessionRecords();

        $this->dispatch('loggedOut');

        $this->closeModal();
    }

    public static function modalMaxWidth(): string
    {
        return 'lg';
    }

    public function render(): View
    {
        return view('tinoecom::livewire.modals.logout-others-browser');
    }

    protected function deleteOtherSessionRecords(): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::table('sessions')
            ->where('user_id', auth()->user()->getKey())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }
}
