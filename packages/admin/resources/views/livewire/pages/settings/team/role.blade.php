<div x-data="{
    options: ['role', 'users', 'permissions'],
    currentTab: 'role',
}" class="pb-10">
    <x-tinoecom::container>
        <x-tinoecom::breadcrumb :back="route('tinoecom.settings.users')" :current="$role->display_name">
            <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
            <x-tinoecom::breadcrumb.link
                :link="route('tinoecom.settings.users')"
                :title="__('tinoecom::pages/settings/menu.staff')"
            />
        </x-tinoecom::breadcrumb>

        <x-tinoecom::heading class="my-6" :title="$role->display_name">
            <x-slot name="action">
                <div class="flex space-x-3">
                    {{ $this->deleteAction }}

                    <x-tinoecom::buttons.primary
                        wire:click="$dispatch(
                            'openModal',
                            {
                                component: 'tinoecom-modals.create-permission',
                                arguments: { 'id': {{  $role->id }} }
                             }
                        )"
                        type="button"
                    >
                        <x-untitledui-lock-04 class="mr-2 size-5" aria-hidden="true" />
                        {{ __('tinoecom::pages/settings/staff.create_permission') }}
                    </x-tinoecom::buttons.primary>
                </div>
            </x-slot>
        </x-tinoecom::heading>
    </x-tinoecom::container>

    <div class="relative border-t border-gray-200 dark:border-white/10">
        <x-filament::tabs :contained="true">
            <x-filament::tabs.item alpine-active="currentTab === 'role'" x-on:click="currentTab = 'role'">
                {{ __('tinoecom::forms.label.role') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="currentTab === 'users'" x-on:click="currentTab = 'users'">
                {{ __('tinoecom::words.users') }}
            </x-filament::tabs.item>
            <x-filament::tabs.item alpine-active="currentTab === 'permissions'" x-on:click="currentTab = 'permissions'">
                {{ __('tinoecom::pages/settings/staff.permissions') }}
            </x-filament::tabs.item>
        </x-filament::tabs>
    </div>

    <div class="mt-10">
        <div x-show="currentTab === 'role'">
            <x-tinoecom::container>
                <div class="w-full space-y-6 lg:max-w-4xl">
                    @if (config('tinoecom.core.users.admin_role') === $role->name)
                        <div class="rounded-md bg-info-500 bg-opacity-10 p-4">
                            <div class="flex">
                                <div class="shrink-0">
                                    <x-untitledui-alert-circle class="size-5 text-info-400" aria-hidden="true" />
                                </div>
                                <div class="ml-3 flex-1 lg:flex lg:justify-between">
                                    <p class="text-sm leading-5 text-info-700">
                                        {{ __('tinoecom::pages/settings/staff.role_alert_msg') }}
                                    </p>
                                    <p class="mt-3 text-sm leading-5 lg:ml-6 lg:mt-0">
                                        <a
                                            href="https://laraveltinoecom.dev/roles-permissions"
                                            target="_blank"
                                            class="whitespace-no-wrap font-medium text-info-700 transition duration-150 ease-in-out hover:text-info-600"
                                        >
                                            {{ __('tinoecom::words.learn_more') }} &rarr;
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="save">
                        {{ $this->form }}

                        <div class="mt-5 text-right">
                            <x-tinoecom::buttons.primary type="submit" wire:loading.attr="disabled">
                                <x-tinoecom::loader wire:loading wire:target="save" class="text-white" />
                                {{ __('tinoecom::forms.actions.update') }}
                            </x-tinoecom::buttons.primary>
                        </div>
                    </form>
                </div>
            </x-tinoecom::container>
        </div>
        <div x-cloak x-show="currentTab === 'users'">
            <livewire:tinoecom-settings.team.users :role="$role" />
        </div>
        <div x-cloak x-show="currentTab === 'permissions'">
            <livewire:tinoecom-settings.team.permissions :role="$role" />
        </div>
    </div>

    <div x-data>
        <template x-teleport="body">
            <x-filament-actions::modals />
        </template>
    </div>
</div>
