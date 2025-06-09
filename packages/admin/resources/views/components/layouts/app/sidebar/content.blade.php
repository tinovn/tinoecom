<div {{ $attributes }}>
    <div class="h-1 rounded-tr-lg rounded-br-lg bg-gradient-to-br from-primary-600 to-primary-100 dark:to-primary-600/10"></div>
    <div class="flex h-full flex-col">
        <div class="px-4 py-5">
            <div
                class="relative flex items-start rounded-lg bg-white px-3 py-2.5 shadow-sm ring-1 ring-gray-200 dark:bg-white/5 dark:ring-gray-800"
            >
                <x-tinoecom::link class="shrink-0" href="{{ route('tinoecom.dashboard') }}">
                    <x-tinoecom::brand class="size-9" />
                    <span class="absolute inset-0"></span>
                </x-tinoecom::link>
                <div class="ml-3 truncate">
                    <h4 class="truncate font-heading text-sm font-medium leading-4 text-gray-900 dark:text-white">
                        {{ tinoecom_setting('name') }}
                    </h4>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ tinoecom_setting('email') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex flex-1 flex-col justify-between overflow-hidden">
            <div class="h-full flex-1 overflow-y-scroll">
                <x-tinoecom::layouts.app.sidebar.secondary />
            </div>

            <div class="space-y-2 border-t border-gray-200 p-4 dark:border-white/10">
                @can('access_setting')
                    <x-tinoecom::link
                        href="{{ route('tinoecom.settings.index') }}"
                        @class([
                            'sh-sidebar-item gap-2',
                            'sh-sidebar-item-active' => request()->routeIs('tinoecom.settings*'),
                            'sh-sidebar-item-inactive' => ! request()->routeIs('tinoecom.settings*'),
                        ])
                    >
                        <x-untitledui-sliders
                            @class(['size-5', 'text-gray-400' => ! request()->routeIs('tinoecom.settings*')])
                            stroke-width="1.5"
                            aria-hidden="true"
                        />
                        {{ __('tinoecom::pages/settings/global.menu') }}
                    </x-tinoecom::link>
                @endcan

                <a href="https://laraveltinoecom.dev" target="_blank" class="sh-sidebar-item gap-2 sh-sidebar-item-inactive">
                    <x-untitledui-code-browser class="size-5 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                    {{ __('tinoecom::pages/dashboard.cards.doc_title') }}
                </a>
            </div>
        </div>
    </div>
</div>
