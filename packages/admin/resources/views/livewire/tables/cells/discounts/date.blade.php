@php
    $discount = $getRecord();
@endphp

<div class="flex shrink-0 items-center gap-3">
    <x-filament::badge :color="$discount->start_at <= now() ? 'success' : 'warning'">
        @if ($discount->start_at <= now())
            {{ __('tinoecom::words.active_for_users') }}
        @else
            {{ __('tinoecom::words.scheduled') }}
        @endif
    </x-filament::badge>
    <p class="text-sm leading-6 text-gray-500 dark:text-gray-400">
        @if ($discount->end_at)
            <span>{{ $discount->start_at->format('d M, Y') }}</span>
            <span>-</span>
            <span>{{ $discount->end_at->format('d M, Y') }}</span>
        @else
            <span>
                {{ __('tinoecom::words.from_date', ['date' => $discount->start_at->format('d M, Y')]) }}
            </span>
        @endif
    </p>
</div>
