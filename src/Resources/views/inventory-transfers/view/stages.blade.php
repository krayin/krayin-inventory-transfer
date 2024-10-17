<!-- Stages  -->
<div class="flex">
    @foreach (array_slice($statuses = $inventoryTransfer->status->cases(), 0, -1) as $key => $status)
        @if ($inventoryTransfer->from_warehouse == $inventoryTransfer->to_warehouse)
            @if (in_array($status, [
                $inventoryTransfer->status::INVENTORY_LOADED,
                $inventoryTransfer->status::INVENTORY_IN_TRANSIT,
            ]))
                @continue
            @endif
        @endif

        @if ($inventoryTransfer->total_qty_picked)
            @if (
                $inventoryTransfer->status::INVENTORY_PICKED === $status
                && $inventoryTransfer->total_qty_picked != $inventoryTransfer->total_qty_requested
            )
                @continue;
            @elseif (
                $inventoryTransfer->status::INVENTORY_PARTIALLY_PICKED === $status
                && $inventoryTransfer->total_qty_picked == $inventoryTransfer->total_qty_requested
            )
                @continue;
            @endif
        @else
            @if ($inventoryTransfer->status::INVENTORY_PARTIALLY_PICKED === $status)
                @continue;
            @endif
        @endif


        @if ($inventoryTransfer->total_qty_received)
            @if (
                $inventoryTransfer->status::INVENTORY_RECEIVED === $status
                && $inventoryTransfer->total_qty_received != $inventoryTransfer->total_qty_picked
            )
                @continue;
            @elseif (
                $inventoryTransfer->status::INVENTORY_PARTIALLY_RECEIVED === $status
                && $inventoryTransfer->total_qty_received == $inventoryTransfer->total_qty_picked
            )
                @continue;
            @endif
        @else
            @if ($inventoryTransfer->status::INVENTORY_PARTIALLY_RECEIVED === $status)
                @continue;
            @endif
        @endif

        <div
            class="stage relative flex h-7 min-w-24 items-center justify-center bg-white pl-7 pr-4 dark:bg-gray-900 ltr:first:rounded-l-lg rtl:first:rounded-r-lg ltr:last:rounded-r-lg rtl:last:rounded-l-lg last:after:hidden {{ $status->index() <= $inventoryTransfer->status->index() ? '!bg-green-500 text-white dark:text-gray-900 ltr:after:bg-green-500 rtl:before:bg-green-500' : ''}}"
        >
            <span class="z-20 whitespace-nowrap text-sm font-medium dark:text-white">
                {{ $status->label() }}
            </span>
        </div>

        @if (
            $key == 0
            && $inventoryTransfer->status == $inventoryTransfer->status::CANCELED
        )
            <div
                class="stage relative flex h-7 min-w-24 items-center justify-center bg-green-500 pl-7 pr-4 text-white rtl:first:rounded-r-lg"
            >
                <span class="z-20 whitespace-nowrap text-sm font-medium dark:text-white">
                    {{ end($statuses)->label() }}
                </span>
            </div>

            @php
                break;
            @endphp
        @endif
    @endforeach
</div>