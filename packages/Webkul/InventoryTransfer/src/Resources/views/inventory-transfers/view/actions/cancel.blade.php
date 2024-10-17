<div>
    <button
        class="flex h-[74px] w-[84px] flex-col items-center justify-center gap-1 rounded-lg border border-transparent bg-red-200 text-red-800 transition-all hover:border-red-400"
        @click="$refs.cancelInventoryTransferModal.open()"
    >
        <span class="icon-cross-large text-2xl dark:!text-red-800"></span>

        @lang('inventory_transfer::app.inventory-transfers.view.actions.cancel.title')
    </button>

    <Teleport to="body">
        <x-admin::form
            :action="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            method="PUT"
        >
            <x-admin::modal ref="cancelInventoryTransferModal">
                <!-- Modal Header !-->
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.cancel.title')
                    </p>
                </x-slot>

                <!-- Modal Content !-->
                <x-slot:content>
                    <input name="status" type="hidden" value="{{ $inventoryTransfer->status::CANCELED }}">
                    
                    <!-- Cancel Reason -->
                    <x-admin::form.control-group class="mb-0">
                        <x-admin::form.control-group.label class="required">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.cancel.reason')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="cancel_description"
                            rules="required"
                            :label="trans('inventory_transfer::app.inventory-transfers.view.actions.cancel.reason')"
                            :placeholder="trans('inventory_transfer::app.inventory-transfers.view.actions.cancel.reason')"
                        />

                        <x-admin::form.control-group.error control-name="cancel_description" />
                    </x-admin::form.control-group>
                </x-slot>

                <x-slot:footer>
                    <button class="primary-button">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.cancel.save-btn')
                    </button>
                </x-slot>
            </x-admin::modal>
        </x-admin::form>
    </Teleport>
</div>