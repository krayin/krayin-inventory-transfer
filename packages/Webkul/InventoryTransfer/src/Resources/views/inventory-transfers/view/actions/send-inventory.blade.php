<div>
    <button
        class="flex w-full items-center justify-center gap-2 rounded-lg border border-transparent bg-green-200 p-3 font-medium text-green-800 transition-all hover:border-green-400"
        @click="$refs.sendInventoryModal.open()"
    >
        <span class="icon-sent text-2xl dark:!text-green-800"></span>

        @lang('inventory_transfer::app.inventory-transfers.view.actions.send-inventory.title')
    </button>

    <Teleport to="body">
        <x-admin::form
            :action="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            method="PUT"
        >
            <x-admin::modal ref="sendInventoryModal">
                <!-- Modal Header !-->
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.send-inventory.title')
                    </p>
                </x-slot>

                <!-- Modal Content !-->
                <x-slot:content>
                    <input name="status" type="hidden" value="{{ $inventoryTransfer->status::INVENTORY_IN_TRANSIT }}">
                    
                    <!-- Cancel Reason -->
                    <x-admin::attributes
                        :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                            'entity_type' => 'inventory_transfers',
                            ['code', 'IN', ['shipping_method', 'tracking_number']],
                        ])"
                        :entity="$inventoryTransfer"
                    />
                </x-slot>

                <x-slot:footer>
                    <button class="primary-button">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.send-inventory.save-btn')
                    </button>
                </x-slot>
            </x-admin::modal>
        </x-admin::form>
    </Teleport>
</div>