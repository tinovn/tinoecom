<x-tinoecom::modal
    headerClasses="p-4 sm:px-6 sm:py-4 border-b border-gray-100 dark:border-white/10"
    contentClasses="relative p-4 sm:px-6 sm:px-5"
    footerClasses="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
>
    <x-slot name="title">
        {{ __('tinoecom::pages/products.related.modal.title') }}
    </x-slot>

    <x-slot name="content">
        <div class="py-2">
            <x-tinoecom::forms.search
                :label="__('tinoecom::pages/products.related.modal.search')"
                :placeholder="__('tinoecom::pages/products.related.modal.search_placeholder')"
                wire:model.live.debounce.550ms="search"
            />
        </div>
        <div class="-mx-2 my-2 h-80 divide-y divide-gray-200 overflow-auto dark:divide-white/10">
            @forelse ($this->products as $product)
                <x-tinoecom::forms.label-product :product="$product" wire:key="{{ $product->id }}" />
            @empty
                <div class="flex h-full items-center justify-center p-4">
                    <div class="text-center">
                        <x-untitledui-book-open
                            class="mx-auto size-8 text-gray-400 dark:text-gray-500"
                            stroke-width="1.5"
                            aria-hidden="true"
                        />
                        <p class="mt-2 font-medium text-gray-900 dark:text-white">
                            {{ __('tinoecom::pages/products.related.modal.no_results') }}
                        </p>
                    </div>
                </div>
            @endforelse
        </div>
    </x-slot>

    <x-slot name="buttons">
        @if ($this->products->isNotEmpty())
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
        @endif

        <x-tinoecom::buttons.default
            wire:click="$dispatch('closeModal')"
            type="button"
            class="mt-3 w-full sm:mt-0 sm:w-auto"
        >
            {{ __('tinoecom::forms.actions.cancel') }}
        </x-tinoecom::buttons.default>
    </x-slot>
</x-tinoecom::modal>
