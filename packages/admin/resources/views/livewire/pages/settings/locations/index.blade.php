<x-tinoecom::container>
    <x-tinoecom::breadcrumb
        :back="route('tinoecom.settings.index')"
        :current="__('tinoecom::pages/settings/global.location.menu')"
    >
        <x-untitledui-chevron-left class="size-4 shrink-0 text-gray-300 dark:text-gray-600" aria-hidden="true" />
        <x-tinoecom::breadcrumb.link
            :link="route('tinoecom.settings.index')"
            :title="__('tinoecom::pages/settings/global.menu')"
        />
    </x-tinoecom::breadcrumb>

    <x-tinoecom::heading class="my-6" :title="__('tinoecom::pages/settings/global.location.menu')">
        <x-slot name="action">
            @can('add_inventories')
                @if ($inventories->count() < (int) config('tinoecom.admin.inventory_limit') + 1)
                    <div class="flex">
                        <x-tinoecom::buttons.primary :link="route('tinoecom.settings.locations.create')">
                            {{ __('tinoecom::forms.actions.add_label', ['label' => __('tinoecom::pages/settings/global.location.single')]) }}
                        </x-tinoecom::buttons.primary>
                    </div>
                @endif
            @endcan
        </x-slot>
    </x-tinoecom::heading>

    <div class="mt-10 lg:grid lg:grid-cols-3 lg:gap-x-12 lg:gap-y-6">
        <div class="lg:col-span-1">
            <div>
                <x-filament::section.heading>
                    {{ __('tinoecom::pages/settings/global.location.menu') }}
                </x-filament::section.heading>
                <x-filament::section.description class="mt-1">
                    {{ __('tinoecom::pages/settings/global.location.description') }}
                </x-filament::section.description>
                <x-filament::section.description class="mt-3">
                    {{ __('tinoecom::pages/settings/global.location.count', ['count' => $inventories->count(), 'total' => config('tinoecom.admin.inventory_limit')]) }}
                </x-filament::section.description>
            </div>
        </div>
        <div class="mt-5 lg:col-span-2 lg:mt-0">
            <x-tinoecom::card class="overflow-hidden">
                <ul class="divide-y divide-gray-200 dark:divide-white/10">
                    @foreach ($inventories as $inventory)
                        <li class="p-4 sm:p-6">
                            <div class="flex items-end gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p
                                            class="truncate text-sm font-medium leading-5 text-primary-600 dark:text-primary-500"
                                        >
                                            {{ $inventory->name }}
                                        </p>
                                        @if ($inventory->is_default)
                                            <div class="ml-2 flex shrink-0">
                                                <x-filament::badge color="gray">
                                                    {{ __('tinoecom::words.default') }}
                                                </x-filament::badge>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-2 sm:flex sm:justify-between">
                                        <div class="sm:flex sm:gap-x-4">
                                            @if ($inventory->country)
                                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                                <img
                                                    src="{{ $inventory->country->svg_flag }}"
                                                    alt="{{ $inventory->country->name }} flag"
                                                    class="size-5 shrink-0 rounded-full object-cover"
                                                />
                                                {{ $inventory->country->name }}
                                            </div>
                                            @endif
                                            <div class="mt-2 flex gap-2 items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                                <x-untitledui-marker-pin-02
                                                    class="size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                                    aria-hidden="true"
                                                />
                                                {{ $inventory->city }}
                                            </div>
                                            <div class="mt-2 flex gap-2 items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                                <x-untitledui-phone
                                                    class="size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                                    aria-hidden="true"
                                                />
                                                {{ $inventory->phone_number ?? __('tinoecom::words.number_not_set') }}
                                            </div>
                                        </div>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
                                            <x-untitledui-calendar
                                                class="size-5 shrink-0 text-gray-400 dark:text-gray-500"
                                                aria-hidden="true"
                                            />
                                            <span class="ml-2">
                                                {{ __('tinoecom::words.added_on') }}
                                                <time
                                                    class="capitalize"
                                                    datetime="{{ $inventory->created_at->format('d-m-Y') }}"
                                                >
                                                    {{ $inventory->created_at->translatedFormat('j F Y') }}
                                                </time>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-tinoecom::link
                                        :href="route('tinoecom.settings.locations.edit', $inventory)"
                                        class="inline-flex size-10 items-center justify-center rounded-full hover:bg-gray-50 dark:hover:bg-gray-900/20"
                                    >
                                        <x-untitledui-edit-03
                                            class="size-5 text-primary-600 dark:text-primary-500"
                                            aria-hidden="true"
                                        />
                                    </x-tinoecom::link>
                                    @if (! $inventory->is_default)
                                        {{ ($this->removeAction)(['id' => $inventory->id]) }}
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </x-tinoecom::card>
        </div>
    </div>

    <div x-data>
        <template x-teleport="body">
            <x-filament-actions::modals />
        </template>
    </div>

    <x-tinoecom::learn-more :name="__('tinoecom::pages/settings/global.location.menu')" link="locations" />
</x-tinoecom::container>
