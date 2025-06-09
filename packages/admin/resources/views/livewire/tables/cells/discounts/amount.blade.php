@php
    $discount = $getRecord();
@endphp

<div>
    @if ($discount->type === \Tinoecom\Core\Enum\DiscountType::Percentage)
        {{ $discount->value . '%' }}
    @else
        {{ tinoecom_money_format(amount: $discount->value, currency: $discount->zone?->currency_code) }}
    @endif
</div>
