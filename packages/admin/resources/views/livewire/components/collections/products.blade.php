<div>
    <x-tinoecom::separator />

    <div>
        <x-filament::section.heading>
            {{ __('tinoecom::pages/products.menu') }}
        </x-filament::section.heading>
        <x-filament::section.description class="mt-1 max-w-2xl">
            @if ($collection->isAutomatic())
                {{ __('tinoecom::pages/collections.automatic_description') }}
            @else
                {{ __('tinoecom::pages/collections.manual_description') }}
            @endif
        </x-filament::section.description>
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</div>
