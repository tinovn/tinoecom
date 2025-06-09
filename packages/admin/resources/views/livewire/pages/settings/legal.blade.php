<div x-data="{
    options: ['privacy', 'terms', 'shipping', 'refund'],
    currentTab: 'privacy',
}">
    <x-tinoecom::container>
        <x-tinoecom::breadcrumb
            :back="route('tinoecom.settings.index')"
            :current="__('tinoecom::pages/settings/global.legal.title')"
        >
            <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
            <x-tinoecom::breadcrumb.link
                :link="route('tinoecom.settings.index')"
                :title="__('tinoecom::pages/settings/global.menu')"
            />
        </x-tinoecom::breadcrumb>
        <x-tinoecom::heading class="my-6" :title="__('tinoecom::pages/settings/global.legal.title')" />
    </x-tinoecom::container>

    <div class="relative border-t border-gray-200 dark:border-white/10">
        <x-filament::tabs :contained="true">
            <x-filament::tabs.item alpine-active="currentTab === 'privacy'" x-on:click="currentTab = 'privacy'">
                {{ __('tinoecom::pages/settings/global.legal.privacy') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="currentTab === 'terms'" x-on:click="currentTab = 'terms'">
                {{ __('tinoecom::pages/settings/global.legal.terms_of_use') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="currentTab === 'shipping'" x-on:click="currentTab = 'shipping'">
                {{ __('tinoecom::pages/settings/global.legal.shipping') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="currentTab === 'refund'" x-on:click="currentTab = 'refund'">
                {{ __('tinoecom::pages/settings/global.legal.refund') }}
            </x-filament::tabs.item>
        </x-filament::tabs>
    </div>

    <x-tinoecom::container class="mt-8">
        @foreach ($legals as $key => $legal)
            <div x-cloak x-show="currentTab === '{{ $key }}'">
                @livewire('tinoecom-settings.legal.'. $key, ['legal' => $legal], key($key))
            </div>
        @endforeach
    </x-tinoecom::container>

    <x-tinoecom::learn-more :name="__('tinoecom::pages/settings/global.legal.title')" link="legal" />
</div>
