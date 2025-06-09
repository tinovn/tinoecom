<x-tinoecom::container class="py-5">
    <x-tinoecom::heading :title="__('tinoecom::pages/settings/global.menu')" />

    <x-tinoecom::card class="mt-8 p-4">
        <div class="grid gap-4 sm:grid-cols-3 sm:gap-x-6 sm:gap-y-4">
            @foreach (config('tinoecom.settings.items', []) as $menu)
                @if ($menu['permission'])
                    @can($menu['permission'])
                        <x-tinoecom::menu.setting :menu="$menu" />
                    @endcan
                @else
                    <x-tinoecom::menu.setting :menu="$menu" />
                @endif
            @endforeach
        </div>
    </x-tinoecom::card>
</x-tinoecom::container>
