<x-tinoecom::container>
    <div>
        <x-filament::section.heading>
            {{ __('tinoecom::pages/products.variants.title') }}
        </x-filament::section.heading>
        <x-filament::section.description class="mt-1 max-w-2xl">
            {{ __('tinoecom::pages/products.variants.description') }}
        </x-filament::section.description>
    </div>

    <div class="mt-8">
        {{ $this->table }}
    </div>
</x-tinoecom::container>
