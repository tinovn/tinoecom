<x-tinoecom::layouts.base :title="$title ?? null">
    <div
        class="flex h-screen overflow-hidden"
        x-data="{ sidebarOpen: false }"
        @keydown.window.escape="sidebarOpen = false"
    >
        <x-tinoecom::layouts.app.sidebar />

        <x-tinoecom::layouts.app.sidebar.mobile />

        <div
            class="flex w-0 flex-1 flex-col overflow-hidden ring-1 ring-gray-200 dark:ring-gray-800 lg:my-2 lg:rounded-bl-2xl lg:rounded-tl-2xl lg:pb-1.5"
        >
            <div class="flex flex-1 flex-col justify-between overflow-hidden overflow-y-auto">
                <x-tinoecom::layouts.app.header />

                @isset($subHeading)
                    {{ $subHeading }}
                @endisset

                <main class="sh-main z-0 flex-1">
                    <div {{ $attributes->twMerge(['class' => 'flex-1 min-h-full']) }}>
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-tinoecom::layouts.base>
