<?php

declare(strict_types=1);

namespace Tinoecom\Core\Helpers;

final class Price
{
    public int | float $amount;

    public string $formatted;

    public string $currency;

    public function __construct(int | float $amount, ?string $currency = null)
    {
        $this->amount = $amount;
        $this->currency = $currency ?? tinoecom_currency();
        $this->formatted = tinoecom_money_format(amount: $this->amount, currency: $this->currency);
    }

    public static function from(int | float $amount, ?string $currency = null): self
    {
        return new self($amount, $currency);
    }
}
