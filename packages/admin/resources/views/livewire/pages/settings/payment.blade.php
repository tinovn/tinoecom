<div x-data="{
    options: @js($tabs),
    currentTab: 'general',
}">
    <x-tinoecom::container>
        <x-tinoecom::breadcrumb
            :back="route('tinoecom.settings.index')"
            :current="__('tinoecom::pages/settings/payments.title')"
        >
            <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
            <x-tinoecom::breadcrumb.link
                :link="route('tinoecom.settings.index')"
                :title="__('tinoecom::pages/settings/global.menu')"
            />
        </x-tinoecom::breadcrumb>
        <x-tinoecom::heading class="my-6" :title="__('tinoecom::pages/settings/payments.title')">
            <x-slot name="action">
                <x-tinoecom::buttons.primary
                    wire:click="$dispatch(
                        'openModal',
                        { component: 'tinoecom-modals.payment-method-form' }
                    )"
                    type="button"
                >
                    {{ __('tinoecom::pages/settings/payments.add_payment') }}
                </x-tinoecom::buttons.primary>
            </x-slot>
        </x-tinoecom::heading>
    </x-tinoecom::container>

    <div class="relative space-y-4 border-gray-200 px-4 dark:border-white/10 lg:border-t lg:px-0">
        <x-filament::tabs :contained="true">
            <x-filament::tabs.item alpine-active="currentTab === 'general'" x-on:click="currentTab = 'general'">
                {{ __('tinoecom::words.general') }}
            </x-filament::tabs.item>
        </x-filament::tabs>
    </div>

    <x-tinoecom::container class="mt-6 pb-10">
        <div x-show="currentTab === 'general'">
            {{ $this->table }}
        </div>
    </x-tinoecom::container>
</div>
