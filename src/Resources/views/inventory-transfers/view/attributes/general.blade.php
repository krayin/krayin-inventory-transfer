{!! view_render_event('admin.inventory_transfers.view.attributes.general.before', ['inventoryTransfer' => $inventoryTransfer]) !!}

<div class="dark: flex w-full flex-col gap-4 border-b border-gray-200 p-4 dark:border-gray-800">
    <h4 class="flex items-center justify-between font-semibold dark:text-white">
        @lang('inventory_transfer::app.inventory-transfers.view.attributes.general.title')
    </h4>

    <x-admin::form
        v-slot="{ meta, errors, handleSubmit }"
        as="div"
        ref="modalForm"
    >
        <form @submit="handleSubmit($event, () => {})">
            <x-admin::attributes.view
                :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                    'entity_type' => 'inventory_transfers',
                    [
                        'code',
                        'NOTIN', [
                            'increment_id',
                            'status',
                            'shipping_method',
                            'tracking_number',
                            'expected_transfer_date',
                            'total_items_count',
                            'total_qty_requested',
                            'total_qty_picked',
                            'total_qty_received',
                            'from_warehouse_id',
                            'to_warehouse_id',
                            'created_by_user_id',
                        ],
                    ],
                ])->sortBy('sort_order')"
                :entity="$inventoryTransfer"
                :allow-edit="bouncer()->hasPermission('inventory_transfers.edit')"
                :url="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            />
        </form>
    </x-admin::form>
</div>

{!! view_render_event('admin.inventory_transfers.view.attributes.general.before', ['inventoryTransfer' => $inventoryTransfer]) !!}
