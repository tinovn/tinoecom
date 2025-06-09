<x-tinoecom::container class="py-5 space-y-5">
    <x-tinoecom::breadcrumb :back="route('tinoecom.dashboard')">
        <x-untitledui-chevron-left class="size-4 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <span class="truncate text-gray-500 dark:text-gray-400">
            {{ __('tinoecom::pages/auth.account.title') }}
        </span>
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading :title="__('tinoecom::pages/auth.account.title')" class="border-b border-gray-200 dark:border-white/10 pb-5" />

    <div>
        <livewire:tinoecom-account.profile />

        <x-tinoecom::separator />

        <livewire:tinoecom-account.password />

        @if (config('tinoecom.auth.2fa_enabled'))
            <x-tinoecom::separator />

            <livewire:tinoecom-account.two-factor />
        @endif

        <x-tinoecom::separator />

        <livewire:tinoecom-account.devices />
    </div>
</x-tinoecom::container>
