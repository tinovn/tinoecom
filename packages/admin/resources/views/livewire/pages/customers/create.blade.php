<x-tinoecom::container class="py-5">
    <x-tinoecom::breadcrumb :back="route('tinoecom.customers.index')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" />
        <x-tinoecom::breadcrumb.link
            :link="route('tinoecom.customers.index')"
            :title="__('tinoecom::pages/customers.menu')"
        />
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading class="pt-6" :title="__('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/customers.single')])" />

    <form wire:submit="store" class="mt-10">
        {{ $this->form }}

        <div class="mt-10 border-t border-gray-200 pt-10 dark:border-white/10">
            <div class="flex justify-end">
                <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                    <x-tinoecom::loader wire:loading wire:target="store" class="text-white" />
                    {{ __('tinoecom::forms.actions.save') }}
                </x-tinoecom::buttons.primary>
            </div>
        </div>
    </form>
</x-tinoecom::container>
