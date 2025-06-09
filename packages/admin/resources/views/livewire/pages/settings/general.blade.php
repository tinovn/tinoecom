<x-tinoecom::container>
    <x-tinoecom::breadcrumb :back="route('tinoecom.settings.index')" :current="__('tinoecom::pages/settings/menu.general')">
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-tinoecom::breadcrumb.link
            :link="route('tinoecom.settings.index')"
            :title="__('tinoecom::pages/settings/global.menu')"
        />
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading class="mt-6" :title="__('tinoecom::pages/settings/global.general.title')" />

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
