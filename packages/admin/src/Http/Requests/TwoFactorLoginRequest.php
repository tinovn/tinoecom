<?php

declare(strict_types=1);

namespace Tinoecom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tinoecom\Contracts\TwoFactorAuthenticationProvider;
use Tinoecom\Facades\Tinoecom;
use Tinoecom\Http\Responses\FailedTwoFactorLoginResponse;

class TwoFactorLoginRequest extends FormRequest
{
    protected $challengedUser;

    protected $remember;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'nullable|string',
            'recovery_code' => 'nullable|string',
        ];
    }

    public function hasValidCode(): bool
    {
        return $this->code && app(TwoFactorAuthenticationProvider::class)->verify(
            decrypt($this->challengedUser()->two_factor_secret),
            $this->code
        );
    }

    public function validRecoveryCode(): ?string
    {
        if (! $this->recovery_code) {
            return null;
        }

        return collect($this->challengedUser()->recoveryCodes())
            ->first(fn ($code) => hash_equals($this->recovery_code, $code) ? $code : null);
    }

    public function hasChallengedUser(): bool
    {
        $model = Tinoecom::auth()->getProvider()->getModel(); // @phpstan-ignore-line

        return $this->session()->has('login.id') &&
            $model::find($this->session()->get('login.id'));
    }

    public function challengedUser()
    {
        if ($this->challengedUser) {
            return $this->challengedUser;
        }

        $model = Tinoecom::auth()->getProvider()->getModel(); // @phpstan-ignore-line

        if (! $this->session()->has('login.id') ||
            ! $user = $model::find($this->session()->pull('login.id'))) {
            throw new HttpResponseException(app(FailedTwoFactorLoginResponse::class)->toResponse($this));
        }

        return $this->challengedUser = $user;
    }

    public function remember(): bool
    {
        if (! $this->remember) {
            $this->remember = $this->session()->pull('login.remember', false);
        }

        return $this->remember;
    }
}
