<x-tinoecom::container class="py-5">
    <x-tinoecom::breadcrumb :back="route('tinoecom.collections.index')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-tinoecom::breadcrumb.link
            :link="route('tinoecom.collections.index')"
            :title="__('tinoecom::pages/collections.menu')"
        />
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading class="mt-6" :title="$collection->name" />

    <form wire:submit="store" class="mt-8 border-t border-gray-200 pt-10 dark:border-white/10">
        <div class="space-y-10">
            {{ $this->form }}

            <div class="border-t border-gray-200 py-8 dark:border-white/10">
                <div class="flex justify-end">
                    <x-tinoecom::buttons.primary type="submit" wire.loading.attr="disabled">
                        <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
                        {{ __('tinoecom::forms.actions.update') }}
                    </x-tinoecom::buttons.primary>
                </div>
            </div>
        </div>
    </form>
</x-tinoecom::container>
