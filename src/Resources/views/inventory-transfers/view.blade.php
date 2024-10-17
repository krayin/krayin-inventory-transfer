<x-admin::layouts>
    <x-slot:title>
        @lang('inventory_transfer::app.inventory-transfers.view.title', ['id' => $inventoryTransfer->increment_id])
    </x-slot>

    <!-- Content -->
    <div class="relative flex gap-4">
        <!-- Left Panel -->
        {!! view_render_event('admin.inventory_transfers.view.left.before', ['inventoryTransfer' => $inventoryTransfer]) !!}

        <div class="sticky top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <!-- Inventory Transfer Information -->
            <div class="flex w-full flex-col gap-2 border-b border-gray-200 p-4 dark:border-gray-800">
                <!-- Breadcrums -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs
                        name="inventory_transfers.view"
                        :entity="$inventoryTransfer"
                    />
                </div>

                <div class="flex flex-col gap-0.5">
                    <!-- Title -->
                    <h3 class="text-lg font-bold dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.title', ['id' => $inventoryTransfer->increment_id])
                    </h1>

                    <div class="dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.created-on', [
                            'date' => $inventoryTransfer->created_at->format('Y-m-d')
                        ])
                    </div>
                </div>

                <!-- Inventory Transfer Actions -->
                @if (
                    bouncer()->hasPermission('inventory_transfers.edit')
                    && $inventoryTransfer->status != $inventoryTransfer->status::CANCELED
                )
                    @switch($inventoryTransfer->status)
                        @case($inventoryTransfer->status::PENDING)
                            @include('inventory_transfer::inventory-transfers.view.actions.pick-inventory')

                        @break

                        @case($inventoryTransfer->status::INVENTORY_PARTIALLY_PICKED)
                            @include('inventory_transfer::inventory-transfers.view.actions.pick-inventory')
                            
                            @if ($inventoryTransfer->from_warehouse != $inventoryTransfer->to_warehouse)
                                @include('inventory_transfer::inventory-transfers.view.actions.load-inventory')
                            @else
                                @include('inventory_transfer::inventory-transfers.view.actions.receive-inventory')
                            @endif

                            @break

                        @case($inventoryTransfer->status::INVENTORY_PICKED)
                            @if ($inventoryTransfer->from_warehouse != $inventoryTransfer->to_warehouse)
                                @include('inventory_transfer::inventory-transfers.view.actions.load-inventory')
                            @else
                                @include('inventory_transfer::inventory-transfers.view.actions.receive-inventory')
                            @endif

                            @break

                        @case($inventoryTransfer->status::INVENTORY_LOADED)
                            @include('inventory_transfer::inventory-transfers.view.actions.send-inventory')

                            @break

                        @case($inventoryTransfer->status::INVENTORY_IN_TRANSIT)
                            @include('inventory_transfer::inventory-transfers.view.actions.receive-inventory')

                            @break

                        @case($inventoryTransfer->status::INVENTORY_PARTIALLY_RECEIVED)
                            @if ($inventoryTransfer->total_qty_picked == $inventoryTransfer->total_qty_received)
                                @include('inventory_transfer::inventory-transfers.view.actions.pick-inventory')
                            @else
                                @include('inventory_transfer::inventory-transfers.view.actions.receive-inventory')
                            @endif

                            @break
                    @endswitch
                @endif

                <!-- Activity Actions -->
                <div class="flex flex-wrap gap-2">
                    @if (bouncer()->hasPermission('activities.create'))
                        <!-- File Activity Action -->
                        <x-admin::activities.actions.file
                            :entity="$inventoryTransfer"
                            entity-control-name="inventory_transfer_id"
                        />

                        <!-- Note Activity Action -->
                        <x-admin::activities.actions.note
                            :entity="$inventoryTransfer"
                            entity-control-name="inventory_transfer_id"
                        />

                        <!-- Print Action -->
                        @if (
                            $inventoryTransfer->status != $inventoryTransfer->status::PENDING
                            && $inventoryTransfer->status != $inventoryTransfer->status::CANCELED
                        )
                            <a
                                href="{{ route('admin.inventory_transfers.print', $inventoryTransfer->id) }}"
                                class="flex h-[74px] w-[84px] flex-col items-center justify-center gap-1 rounded-lg border border-transparent bg-blue-200 text-blue-800 transition-all hover:border-blue-400"
                            >
                                <span class="icon-print text-2xl dark:!text-blue-800"></span>

                                @lang('inventory_transfer::app.inventory-transfers.view.print')
                            </a>
                        @endif

                        <!-- Cancel Action -->
                        @includeWhen(bouncer()->hasPermission('inventory_transfers.edit') && $inventoryTransfer->status == $inventoryTransfer->status::PENDING, 'inventory_transfer::inventory-transfers.view.actions.cancel')
                    @endif
                </div>
            </div>
            
            <!-- Inventory Transfer General Attributes -->
            @include('inventory_transfer::inventory-transfers.view.attributes.general')

            <!-- Inventory Transfer Delivery Attributes -->
            @include('inventory_transfer::inventory-transfers.view.attributes.delivery')
        </div>

        {!! view_render_event('admin.inventory_transfers.view.left.after', ['inventoryTransfer' => $inventoryTransfer]) !!}

        <!-- Right Panel -->
        {!! view_render_event('admin.inventory_transfers.view.right.before', ['inventoryTransfer' => $inventoryTransfer]) !!}
        
        <div class="flex w-full flex-col gap-4 rounded-lg">
            <!-- Inventory Transfer Delivery Attributes -->
            @include('inventory_transfer::inventory-transfers.view.stages')

            <!-- Activities -->
            {!! view_render_event('admin.inventory_transfers.view.activities.before', ['inventoryTransfer' => $inventoryTransfer]) !!}

            <x-admin::activities
                :endpoint="route('admin.inventory_transfers.activities.index', $inventoryTransfer->id)" 
                :active-type="$inventoryTransfer->status == $inventoryTransfer->status::PENDING ? 'items': 'all'"
                :types="[
                    ['name' => 'all', 'label' => trans('inventory_transfer::app.inventory-transfers.view.all')],
                    ['name' => 'note', 'label' => trans('inventory_transfer::app.inventory-transfers.view.notes')],
                    ['name' => 'file', 'label' => trans('inventory_transfer::app.inventory-transfers.view.files')],
                    ['name' => 'system', 'label' => trans('inventory_transfer::app.inventory-transfers.view.change-logs')],
                ]"
                :extra-types="[
                    ['name' => 'items', 'label' => trans('inventory_transfer::app.inventory-transfers.view.items-tab')],
                ]"
            >
                <!-- Items -->
                <x-slot:items>
                    @include ('inventory_transfer::inventory-transfers.view.items')
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.inventory_transfers.view.activities.after', ['inventoryTransfer' => $inventoryTransfer]) !!}
        </div>

        {!! view_render_event('admin.inventory_transfers.view.right.after', ['inventoryTransfer' => $inventoryTransfer]) !!}
    </div>
</x-admin::layouts>
