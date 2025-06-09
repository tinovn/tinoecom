<x-tinoecom::container class="space-y-8">
    <div>
        <x-filament::section.heading>
            {{ __('tinoecom::pages/attributes.menu') }}
        </x-filament::section.heading>
        <x-filament::section.description class="mt-1 max-w-2xl">
            {{ __('tinoecom::pages/attributes.description') }}
        </x-filament::section.description>
    </div>

    <div class="mt-8">
        {{ $this->table }}
    </div>
</x-tinoecom::container>
