@component('tinoecom::mails.html.layout')
    {{-- Header --}}
    @slot('header')
        @component('tinoecom::mails.html.header', ['url' => config('app.url'), 'description' => __('Online Shopping tool')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('tinoecom::mails.html.subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('tinoecom::mails.html.footer')
            © {{ date('Y') }} {{ config('app.name') }}.
            @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
