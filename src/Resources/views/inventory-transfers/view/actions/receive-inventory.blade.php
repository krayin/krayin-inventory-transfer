<div>
    <button
        class="flex w-full items-center justify-center gap-2 rounded-lg border border-transparent bg-green-200 p-3 font-medium text-green-800 transition-all hover:border-green-400"
        @click="$refs.receiveInventoryDrawer.open()"
    >
        <span class="icon-receive-inventory text-2xl dark:!text-green-800"></span>

        @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.title')
    </button>

    <Teleport to="body">
        <x-admin::drawer ref="receiveInventoryDrawer">
            <!-- Drawer Content -->
            <x-slot:content class="!p-0">

                <!-- Inventory Receive Vue Componenent -->
                <v-receive-inventory></v-receive-inventory>

            </x-slot>
        </x-admin::drawer>
    </Teleport>
</div>

@push('scripts')
    <script type="text/x-template" id="v-receive-inventory-template">
        <x-admin::form
            :action="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            method="PUT"
        >
            <template v-if="inventoryTransfer.total_qty_ordered > totalQtyReceived">
                <input name="status" type="hidden" value="{{ $inventoryTransfer->status::INVENTORY_PARTIALLY_RECEIVED }}">
            </template>

            <template v-else>
                <input name="status" type="hidden" value="{{ $inventoryTransfer->status::INVENTORY_RECEIVED }}">
            </template>

            <div class="grid gap-y-2.5 border-b p-3 dark:border-gray-800 max-sm:px-4">
                <div class="flex items-center justify-between">
                    <!-- Title -->
                    <p class="text-xl font-medium dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.title')
                    </p>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <button
                            class="primary-button"
                        >
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.save-btn')
                        </button>
                        
                        <span
                            class="icon-cross-large cursor-pointer text-3xl hover:rounded-md hover:bg-gray-100 dark:hover:bg-gray-950"
                            @click="$root.$refs.receiveInventoryDrawer.close()"
                        >
                        </span>
                    </div>
                </div>
            </div>

            <x-admin::table class="!min-w-max border-x-0">
                <x-admin::table.thead>
                    <x-admin::table.thead.tr>
                        <x-admin::table.th class="!p-3">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.products')
                        </x-admin::table.th>

                        <x-admin::table.th class="!p-3">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.receive-qty')
                        </x-admin::table.th>
                    </x-admin::table.thead.tr>
                </x-admin::table.thead>

                <x-admin::table.tbody>
                    <!-- Items -->
                    <template v-for="item in inventoryTransfer.items">
                        <v-receive-inventory-item
                            :key="item.id"
                            :item="item"
                            :warehouse-locations="warehouseLocations"
                            v-if="item.qty_picked > item.qty_received"
                        ></v-receive-inventory-item>
                    </template>
                </x-admin::table.tbody>
            </x-admin::table>
        </x-admin::form>
    </script>

    <script type="text/x-template" id="v-receive-inventory-item-template">
        <x-admin::table.tbody.tr>
            <!-- Product Information -->
            <x-admin::table.td class="flex flex-col gap-1 !p-3">
                <span>
                    <a
                        :href="'{{ route('admin.products.view', '') }}/' + item.product_id"
                        class="font-medium text-brandColor"
                        target="_blank"
                    >
                        @{{ item.name }}
                    </a>
                </span>

                <span>
                    @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.sku'):

                    @{{ item.sku }}
                </span>

                <span>
                    @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.on-order'):

                    @{{ item.qty_picked }}
                </span>
            </x-admin::table.td>

            <!-- Cost Price -->
            <x-admin::table.td class="!p-3">
                <div class="flex flex-col gap-1">
                    <div
                        class="flex items-start gap-2"
                        v-for="(addedLocation, index) in neededAddedLocations"
                    >
                        <x-admin::form.control-group class="!mb-0 w-28">
                            <x-admin::form.control-group.control
                                type="text"
                                ::name="'items[' + item.id + '][' + index + '][qty_received]'"
                                ::rules="{required: true, numeric: true, min_value: 1, max_value: item.qty_picked - item.qty_received}"
                                v-model="addedLocation.qty"
                                label="{{ trans('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.qty') }}"
                            />

                            <v-error-message
                                :name="'items[' + item.id + '][' + index + '][qty_received]'"
                                v-slot="{ message }"
                            >
                                <p
                                    class="mt-1 whitespace-normal text-xs italic text-red-600"
                                    v-text="message"
                                >
                                </p>
                            </v-error-message>
                        </x-admin::form.control-group>

                        <span class="mt-2">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.in')
                        </span>

                        <x-admin::form.control-group class="!mb-0 w-28">
                            <x-admin::form.control-group.control
                                type="select"
                                ::name="'items[' + item.id + '][' + index + '][location_id]'"
                                rules="required"
                                v-model="addedLocation.id"
                                label="{{ trans('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.qty') }}"
                            >
                                <option
                                    v-for="warehouseLocation in remainingLocations(addedLocation)"
                                    :value="warehouseLocation.id"
                                >
                                    @{{ warehouseLocation.name }}
                                </option>
                            </x-admin::form.control-group.control>

                            <v-error-message
                                :name="'items[' + item.id + '][' + index + '][location_id]'"
                                v-slot="{ message }"
                            >
                                <p
                                    class="mt-1 whitespace-normal text-xs italic text-red-600"
                                    v-text="message"
                                >
                                </p>
                            </v-error-message>
                        </x-admin::form.control-group>
                    </div>

                    <span
                        class="cursor-pointer font-medium text-brandColor"
                        v-if="remainingQty > 0"
                        @click="addLocation"
                    >
                        + @lang('inventory_transfer::app.inventory-transfers.view.actions.receive-inventory.add-location')
                    </span>
                </div>
            </x-admin::table.td>
        </x-admin::table.thead.tr>
    </script>

    <script type="module">
        app.component('v-receive-inventory', {
            template: '#v-receive-inventory-template',

            data() {
                return {
                    inventoryTransfer: @json($inventoryTransfer),

                    warehouseLocations: [],
                }
            },

            mounted() {
                this.getInventoryTransfer();
            },

            computed: {
                totalQtyReceived() {
                    return this.inventoryTransfer.items?.reduce((total, item) => total + (item.qty_to_receive ?? 0) + item.qty_received, 0) ?? 0;
                }
            },

            methods: {
                getInventoryTransfer() {
                    let self = this;

                    this.$axios.get("{{ route('admin.inventory_transfers.get', $inventoryTransfer->id) }}")
                        .then(function(response) {
                            self.inventoryTransfer = response.data.data;

                            self.getWarehouseLocations();
                        })
                        .catch(function (error) {
                        });
                },
                
                getWarehouseLocations() {
                    let self = this;

                    this.$axios.get("{{ route('admin.settings.locations.search') }}", {
                            params: {
                                search: 'warehouse_id:' + self.inventoryTransfer.to_warehouse.id,
                                searchFields: 'warehouse_id:=',
                            }
                        })
                        .then(function(response) {
                            self.warehouseLocations = response.data.data;
                        })
                        .catch(function (error) {
                        });
                }
            }
        });

        app.component('v-receive-inventory-item', {
            template: '#v-receive-inventory-item-template',

            props: ['item', 'warehouseLocations'],

            data() {
                return {
                    addedLocations: [{
                        id: this.item.to_locations[0]?.id ?? null,
                        qty: this.item.qty_picked - this.item.qty_received,
                    }]
                }
            },

            computed: {
                remainingQty() {
                    const totalAddedQty = this.addedLocations.reduce((total, location) => total + parseInt(location.qty || 0), 0);
                    
                    let remainingQty = Math.max(0, this.item.qty_picked - this.item.qty_received - totalAddedQty);

                    if (totalAddedQty > this.item.qty_picked - this.item.qty_received) {
                        // Adjust the quantities in addedLocations to not exceed qty_picked
                        let excess = totalAddedQty - this.item.qty_picked - this.item.qty_received;

                        for (let i = this.addedLocations.length - 1; i >= 0 && excess > 0; i--) {
                            const locationQty = parseInt(this.addedLocations[i].qty || 0);
                            
                            if (locationQty > excess) {
                                this.addedLocations[i].qty = locationQty - excess;

                                excess = 0;
                            } else {
                                excess -= locationQty;
                                
                                this.addedLocations[i].qty = 0;
                            }
                        }
                    }

                    this.item.qty_to_receive = totalAddedQty;

                    return remainingQty;
                },

                neededAddedLocations() {
                    return this.addedLocations.filter(location => location.qty > 0);
                }
            },

            methods: {
                addLocation() {
                    this.addedLocations.push({
                        id: this.item.to_locations[this.addedLocations.length]?.id ?? null,
                        qty: this.remainingQty,
                    });
                },

                remainingLocations(exceptionLocation) {
                    return this.warehouseLocations.filter(location => {
                        return !this.neededAddedLocations.some(addedLocation => addedLocation.id === location.id && addedLocation.id !== exceptionLocation.id);
                    });
                }
            }
        });
    </script>
@endpush