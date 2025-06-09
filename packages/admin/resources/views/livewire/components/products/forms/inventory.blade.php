<x-tinoecom::container>
    <form wire:submit="store">
        {{ $this->form }}

        <div class="mt-8 grid grid-cols-1 gap-x-6 md:grid-cols-3 md:gap-x-12">
            <div class="flex justify-end md:col-span-2 md:col-start-2 lg:max-w-3xl">
                <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                    <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
                    {{ __('tinoecom::forms.actions.update') }}
                </x-tinoecom::buttons.primary>
            </div>
        </div>
    </form>

    <x-tinoecom::separator />

    <section
        class="fi-section fi-aside grid grid-cols-1 items-start gap-x-6 gap-y-4 lg:grid-cols-3 lg:gap-x-12 lg:gap-y-6"
    >
        <div class="grid flex-1 gap-y-1">
            <x-filament::section.heading>
                {{ __('tinoecom::pages/products.inventory.stock_title') }}
            </x-filament::section.heading>
            <x-filament::section.description class="max-w-2xl">
                {{ __('tinoecom::pages/products.inventory.stock_description') }}
            </x-filament::section.description>
        </div>
        <div class="lg:col-span-2">
            {{ $this->table }}
        </div>
    </section>
</x-tinoecom::container>
