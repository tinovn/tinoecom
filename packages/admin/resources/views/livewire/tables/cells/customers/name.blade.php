<div class="text-sm font-medium leading-5 text-gray-900 dark:text-white">
    <div class="flex items-center space-x-2">
        <img
            class="size-8 rounded-full object-cover"
            src="{{ $getRecord()->picture }}"
            alt="{{ $getRecord()->full_name }}"
        />
        <x-tinoecom::link href="{{ route('tinoecom.customers.show', $getRecord()) }}">
            <span class="text-sm font-medium leading-5">
                {{ $getRecord()->full_name }}
            </span>
        </x-tinoecom::link>
    </div>
</div>
