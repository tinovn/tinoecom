<div>
    <div class="flex items-center justify-between">
        <h4 class="text-sm font-medium leading-5 text-gray-900 dark:text-white">
            {{ __('tinoecom::pages/products.quantity_inventory') }}
        </h4>
        <div class="ml-4 flex items-center">
            {{ $this->stockAction }}

            <div x-data>
                <template x-teleport="body">
                    <x-filament-actions::modals />
                </template>
            </div>
        </div>
    </div>

    <div class="mt-5 overflow-hidden bg-white rounded-xl ring-1 ring-gray-950/10 dark:bg-gray-900 dark:ring-white/10">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-white/10">
            <thead class="bg-gray-50 dark:bg-white/5">
                <x-tinoecom::tables.table-head>
                    {{ __('tinoecom::pages/products.inventory_name') }}
                </x-tinoecom::tables.table-head>
                <x-tinoecom::tables.table-head class="text-right">
                    {{ __('tinoecom::words.available') }}
                </x-tinoecom::tables.table-head>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-white/10" x-max="1">
                @foreach ($inventories as $inventory)
                    <tr>
                        <x-tinoecom::tables.table-cell class="whitespace-no-wrap">
                            <div class="flex items-center gap-2">
                                {{ $inventory->name }}

                                @if ($inventory->is_default)
                                    <x-filament::badge color="gray">
                                        {{ __('tinoecom::words.default') }}
                                    </x-filament::badge>
                                @endif
                            </div>
                        </x-tinoecom::tables.table-cell>
                        <x-tinoecom::tables.table-cell class="text-right">
                            {{ $variant->stockInventory($inventory->id) }}
                        </x-tinoecom::tables.table-cell>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
