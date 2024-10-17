<div>
    <button
        class="flex w-full items-center justify-center gap-2 rounded-lg border border-transparent bg-green-200 p-3 font-medium text-green-800 transition-all hover:border-green-400"
        @click="$refs.pickInventoryDrawer.open()"
    >
        <span class="icon-pick-inventory text-2xl dark:!text-green-800"></span>

        @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.title')
    </button>

    <Teleport to="body">
        <x-admin::drawer ref="pickInventoryDrawer">
            <!-- Drawer Content -->
            <x-slot:content class="!p-0">

                <!-- Inventory Pick Vue Componenent -->
                <v-pick-inventory></v-pick-inventory>

            </x-slot>
        </x-admin::drawer>
    </Teleport>
</div>

@push('scripts')
    <script type="text/x-template" id="v-pick-inventory-template">
        <x-admin::form
            :action="route('admin.inventory_transfers.update', $inventoryTransfer->id)"
            method="PUT"
        >
            <input name="status" type="hidden" value="{{ $inventoryTransfer->status::INVENTORY_PICKED }}">

            <div class="grid gap-y-2.5 border-b p-3 dark:border-gray-800 max-sm:px-4">
                <div class="flex items-center justify-between">
                    <!-- Title -->
                    <p class="text-xl font-medium dark:text-white">
                        @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.title')
                    </p>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <button
                            class="primary-button"
                        >
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.save-btn')
                        </button>
                        
                        <span
                            class="icon-cross-large cursor-pointer text-3xl hover:rounded-md hover:bg-gray-100 dark:hover:bg-gray-950"
                            @click="$root.$refs.pickInventoryDrawer.close()"
                        >
                        </span>
                    </div>
                </div>
            </div>

            <x-admin::table class="!min-w-max border-x-0">
                <x-admin::table.thead>
                    <x-admin::table.thead.tr>
                        <x-admin::table.th class="!p-3 rtl:text-right">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.products')
                        </x-admin::table.th>

                        <x-admin::table.th class="!p-3 rtl:text-right">
                            @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.pick-qty')
                        </x-admin::table.th>
                    </x-admin::table.thead.tr>
                </x-admin::table.thead>

                <x-admin::table.tbody>
                    <!-- Items -->
                    <x-admin::table.tbody.tr v-for="item in inventoryTransfer.items">
                        <!-- Product Information -->
                        <x-admin::table.td class="flex flex-col gap-1 !p-3">
                            <a
                                :href="'{{ route('admin.products.view', '') }}/' + item.product_id"
                                class="truncate font-medium text-brandColor"
                                target="_blank"
                            >
                                @{{ item.name }}
                            </a>

                            <span>
                                @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.sku'):

                                @{{ item.sku }}
                            </span>

                            <span>
                                @lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.requested'):

                                @{{ item.qty_requested }}
                            </span>
                        </x-admin::table.td>

                        <!-- Inventories -->
                        <x-admin::table.td class="!p-3">
                            <div class="flex flex-col gap-1">
                                <template v-for="(inventory, index) in item.inventories">
                                    <div
                                        class="flex items-start gap-2"
                                        v-if="inventory.qty_requested > inventory.qty_picked"
                                    >
                                        <x-admin::form.control-group class="!mb-0 w-28">
                                            <x-admin::form.control-group.control
                                                type="text"
                                                ::name="'items[' + item.id + '][' + inventory.location.id + '][qty_picked]'"
                                                ::rules="{required: true, numeric: true, min_value: 0, max_value: inventory.qty_requested - inventory.qty_picked}"
                                                ::value="inventory.qty_requested - inventory.qty_picked"
                                                label="{{ trans('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.qty') }}"
                                            />

                                            <v-error-message
                                                :name="'items[' + item.id + '][' + inventory.location.id + '][qty_picked]'"
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
                                            @{{ "@lang('inventory_transfer::app.inventory-transfers.view.actions.pick-inventory.from', ['location' => 'location'])".replace('location', inventory.location.name) }}
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </x-admin::table.td>
                    </x-admin::table.thead.tr>
                </x-admin::table.tbody>
            </x-admin::table>
        </x-admin::form>
    </script>

    <script type="module">
        app.component('v-pick-inventory', {
            template: '#v-pick-inventory-template',

            data() {
                return {
                    inventoryTransfer: @json($inventoryTransfer),

                    warehouseLocations: [],
                }
            },

            mounted() {
                this.getInventoryTransfer();
            },

            methods: {
                getInventoryTransfer() {
                    let self = this;

                    this.$axios.get("{{ route('admin.inventory_transfers.get', $inventoryTransfer->id) }}")
                        .then(function(response) {
                            self.inventoryTransfer = response.data.data;
                        })
                        .catch(function (error) {
                        });
                },
            }
        });
    </script>
@endpush