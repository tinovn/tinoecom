@if (filled($brand = config('tinoecom.admin.brand')))
    <img {{ $attributes }} src="{{ asset($brand) }}" alt="{{ config('app.name') }}" />
@else
    <img
        {{ $attributes }}
        src="{{ asset(tinoecom()->prefix() . '/images/tinoecom-icon.svg') }}"
        alt="Laravel Tinoecom"
    />
@endif
