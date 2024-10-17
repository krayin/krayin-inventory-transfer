<div>
    <button
        class="flex w-full items-center justify-center gap-2 rounded-lg border border-transparent bg-green-200 p-3 font-medium text-green-800 transition-all hover:border-green-400"
        @click="$refs.loadInventoryModal.open()"
    >
        <span class="icon-load-inventory text-2xl dark:!text-green-800"></span>

        @lang('inventory_transfer::app.inventory-transfers.view.actions.load-inventory.title')
    </button>

    <Teleport to="body">
        <x-admin::form
            :action="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            method="PUT"
        >
            <x-admin::modal ref="loadInventoryModal">
                <!-- Modal Header !-->
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.load-inventory.title')
                    </p>
                </x-slot>

                <!-- Modal Content !-->
                <x-slot:content>
                    <input name="status" type="hidden" value="{{ $inventoryTransfer->status::INVENTORY_LOADED }}">
                    
                    <!-- Cancel Reason -->
                    <x-admin::form.control-group class="mb-0">
                        <x-admin::form.control-group.label>
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.load-inventory.description')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="load_description"
                            :placeholder="trans('inventory_transfer::app.inventory-transfers.view.actions.load-inventory.description')"
                        />
                    </x-admin::form.control-group>
                </x-slot>

                <x-slot:footer>
                    <button class="primary-button">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.load-inventory.save-btn')
                    </button>
                </x-slot>
            </x-admin::modal>
        </x-admin::form>
    </Teleport>
</div>