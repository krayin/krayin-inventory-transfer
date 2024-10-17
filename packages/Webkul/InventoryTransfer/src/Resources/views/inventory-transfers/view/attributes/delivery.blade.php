{!! view_render_event('admin.inventory_transfers.view.attributes.general.before', ['inventoryTransfer' => $inventoryTransfer]) !!}

<div class="dark: flex w-full flex-col gap-4 border-b border-gray-200 p-4 dark:border-gray-800">
    <h4 class="flex items-center justify-between font-semibold dark:text-white">
        @lang('inventory_transfer::app.inventory-transfers.view.attributes.delivery.title')
    </h4>
    
    <div>
        <x-admin::attributes.view
            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                'entity_type' => 'inventory_transfers',
                [
                    'code',
                    'IN', [
                        'from_warehouse_id',
                        'to_warehouse_id',
                    ],
                ],
            ])->sortBy('sort_order')"
            :entity="$inventoryTransfer"
            :allow-edit="false"
            :url="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
        />

        @if ($inventoryTransfer->from_warehouse != $inventoryTransfer->to_warehouse)
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
                                'IN', [
                                    'shipping_method',
                                    'tracking_number',
                                    'expected_transfer_date',
                                ],
                            ],
                        ])->sortBy('sort_order')"
                        :entity="$inventoryTransfer"
                        :allow-edit="bouncer()->hasPermission('inventory_transfers.edit')"
                        :url="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
                    />
                </form>
            </x-admin::form>
        @endif
    </div>
</div>

{!! view_render_event('admin.inventory_transfers.view.attributes.delivery.before', ['inventoryTransfer' => $inventoryTransfer]) !!}
