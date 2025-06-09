<x-tinoecom::container>
    <x-tinoecom::breadcrumb
        :back="route('tinoecom.settings.locations')"
        :current="__('tinoecom::pages/settings/global.location.add')"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" />
        <x-tinoecom::breadcrumb.link
            :link="route('tinoecom.settings.locations')"
            :title="__('tinoecom::pages/settings/global.location.menu')"
        />
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading class="my-6" :title="__('tinoecom::pages/settings/global.location.add')" />

    <livewire:tinoecom-settings.locations.form :inventory="new \Tinoecom\Core\Models\Inventory()" />
</x-tinoecom::container>
