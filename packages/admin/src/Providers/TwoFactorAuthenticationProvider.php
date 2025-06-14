<?php

declare(strict_types=1);

namespace Tinoecom\Providers;

use PragmaRX\Google2FA\Google2FA;
use Tinoecom\Contracts\TwoFactorAuthenticationProvider as TwoFactorAuthenticationProviderContract;

final class TwoFactorAuthenticationProvider implements TwoFactorAuthenticationProviderContract
{
    public function __construct(protected Google2FA $engine) {}

    public function generateSecretKey(): string
    {
        return $this->engine->generateSecretKey();
    }

    public function qrCodeUrl(string $companyName, string $companyEmail, string $secret): string
    {
        return $this->engine->getQRCodeUrl($companyName, $companyEmail, $secret);
    }

    public function verify(string $secret, string $code): bool
    {
        return $this->engine->verifyKey($secret, $code);
    }
}
