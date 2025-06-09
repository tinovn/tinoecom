<x-tinoecom::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-gray-200 dark:border-white/10"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>
    <x-slot name="title">
        {{ __('tinoecom::pages/collections.modal.title') }}
    </x-slot>

    <x-slot name="content">
        <div class="py-2">
            <x-tinoecom::forms.search
                :label="__('tinoecom::pages/collections.modal.search')"
                :placeholder="__('tinoecom::pages/collections.modal.search_placeholder')"
                wire:model.live.debounce.550ms="search"
            />
        </div>
        <div class="h-80 -mx-2 my-2 divide-y divide-gray-200 overflow-auto dark:divide-white/10">
            @foreach ($this->products as $product)
                <x-tinoecom::forms.label-product :product="$product" wire:key="{{ $product->id }}" />
            @endforeach
        </div>
    </x-slot>

    <x-slot name="buttons">
        <x-tinoecom::buttons.primary
            wire:click="addSelectedProducts"
            wire.loading.attr="disabled"
            :disabled="count($selectedProducts) <= 0"
            type="button"
            class="w-full sm:ml-3 sm:w-auto"
        >
            <x-tinoecom::loader wire:loading wire:target="addSelectedProducts" class="text-white" />
            {{ __('tinoecom::pages/collections.modal.action') }}
        </x-tinoecom::buttons.primary>
        <x-tinoecom::buttons.default
            wire:click="$dispatch('closeModal')"
            type="button"
            class="mt-3 w-full sm:mt-0 sm:w-auto"
        >
            {{ __('tinoecom::forms.actions.cancel') }}
        </x-tinoecom::buttons.default>
    </x-slot>
</x-tinoecom::modal>
