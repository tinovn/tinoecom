@can('read_orders')
    <a
        href="{{ route('tinoecom.orders.show', $row) }}"
        class="truncate font-medium text-gray-900 hover:text-gray-700 dark:text-white dark:hover:text-gray-300"
    >
        <span>{{ $row->number }}</span>
    </a>
@else
    <span>{{ $row->number }}</span>
@endcan
