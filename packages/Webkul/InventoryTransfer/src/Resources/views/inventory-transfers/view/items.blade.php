{!! view_render_event('admin.inventory_transfers.view.items.before', ['inventoryTransfer' => $inventoryTransfer]) !!}

<!-- Products Vue Js Component -->
<v-inventory-transfer-items ref="inventoryTransferItems"></v-inventory-transfer-items>

{!! view_render_event('admin.inventory_transfers.view.items.after', ['inventoryTransfer' => $inventoryTransfer]) !!}

@push('scripts')
    <script
        type="text/x-template"
        id="v-inventory-transfer-items-template"
    >
        <div>
            <div
                class="flex flex-col gap-4 p-4"
                v-if="inventoryTransfer?.items?.length"
            >
                <!-- Items Table -->
                <x-admin::table>
                    <x-admin::table.thead>
                        <x-admin::table.thead.tr>
                            <x-admin::table.th>
                                @lang('inventory_transfer::app.inventory-transfers.view.items.sku')
                            </x-admin::table.th>

                            <x-admin::table.th>
                                @lang('inventory_transfer::app.inventory-transfers.view.items.name')
                            </x-admin::table.th>

                            <x-admin::table.th>
                                @lang('inventory_transfer::app.inventory-transfers.view.items.requested-qty')
                            </x-admin::table.th>

                            <x-admin::table.th>
                                @lang('inventory_transfer::app.inventory-transfers.view.items.picked-qty')
                            </x-admin::table.th>

                            <x-admin::table.th>
                                @lang('inventory_transfer::app.inventory-transfers.view.items.received-qty')
                            </x-admin::table.th>

                            <x-admin::table.th v-if="inventoryTransfer.status == 'pending'">
                                @lang('inventory_transfer::app.inventory-transfers.view.items.action')
                            </x-admin::table.th>
                        </x-admin::table.thead.tr>
                    </x-admin::table.thead>

                    <x-admin::table.tbody>
                        <template v-for="item in inventoryTransfer.items">
                            <x-admin::table.tbody.tr>
                                <x-admin::table.td class="truncate">
                                    @{{ item.sku }}
                                </x-admin::table.td>

                                <x-admin::table.td 
                                    class="truncate"
                                    ::title="item.name"
                                >
                                    @{{ item.name }}
                                </x-admin::table.td>

                                <x-admin::table.td>
                                    <template v-if="item.qty_requested">
                                        <div class="flex flex-col gap-1">
                                            <span 
                                                class="text-wrap"
                                                v-for="inventory in item.inventories.filter(inventory => inventory.qty_requested > 0)"
                                            >
                                                @{{ "@lang('inventory_transfer::app.inventory-transfers.view.items.location-qty', ['location' => 'location', 'qty' => 'qty'])".replace('location', inventory.location.name).replace('qty', inventory.qty_requested) }}
                                            </span>
                                        </div>
                                    </template>

                                    <template v-else>
                                        <span class="text-wrap">
                                            @{{ item.qty_requested }}
                                        </span>
                                    </template>
                                </x-admin::table.td>

                                <x-admin::table.td>
                                    <template v-if="item.qty_picked">
                                        <div class="flex flex-col gap-1">
                                            <span v-for="inventory in item.inventories.filter(inventory => inventory.qty_picked > 0)">
                                                @{{ "@lang('inventory_transfer::app.inventory-transfers.view.items.location-qty', ['location' => 'location', 'qty' => 'qty'])".replace('location', inventory.location.name).replace('qty', inventory.qty_picked) }}
                                            </span>
                                        </div>
                                    </template>

                                    <template v-else>
                                        @{{ item.qty_picked }}
                                    </template>
                                </x-admin::table.td>

                                <x-admin::table.td>
                                    <template v-if="item.qty_received">
                                        <div class="flex flex-col gap-1">
                                            <span v-for="inventory in item.inventories.filter(inventory => inventory.qty_received > 0)">
                                                @{{ "@lang('inventory_transfer::app.inventory-transfers.view.items.location-qty', ['location' => 'location', 'qty' => 'qty'])".replace('location', inventory.location.name).replace('qty', inventory.qty_received) }}
                                            </span>
                                        </div>
                                    </template>

                                    <template v-else>
                                        @{{ item.qty_received }}
                                    </template>
                                </x-admin::table.td>

                                <x-admin::table.td v-if="inventoryTransfer.status == 'pending'">
                                    <span
                                        class="icon-delete cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-200 dark:hover:bg-gray-800 max-sm:place-self-center"
                                        @click="remove(item)"
                                    >
                                    </span>
                                </x-admin::table.td>
                            </x-admin::table.thead.tr>
                        </template>
                    </x-admin::table.tbody>
                </x-admin::table>

                <!-- Actions -->
                <div class="flex w-full items-start justify-between">
                    <!-- Add Button -->
                    <button
                        class="w-max cursor-pointer font-semibold text-brandColor"
                        @click="$refs.addProductsDrawer.open()"
                        v-if="inventoryTransfer.status == 'pending'"
                    >
                        + @lang('inventory_transfer::app.inventory-transfers.view.items.add-products-btn')
                    </button>
                </div>
            </div>

            <div v-else>
                <div class="grid justify-center justify-items-center gap-3.5 py-12">
                    <img
                        class="dark:mix-blend-exclusion dark:invert" 
                        src="{{ vite()->asset('images/empty-placeholders/products.svg') }}"
                    >
                    
                    <div class="flex flex-col items-center gap-2">
                        <p class="text-xl font-semibold dark:text-white">
                            @lang('inventory_transfer::app.inventory-transfers.view.items.empty-title')
                        </p>
                        
                        <p class="text-gray-400 dark:text-gray-400">
                            @lang('inventory_transfer::app.inventory-transfers.view.items.empty-info')
                        </p>
                    </div>

                    <div
                        class="secondary-button"
                        @click="$refs.addProductsDrawer.open()"
                    >
                        @lang('inventory_transfer::app.inventory-transfers.view.items.add-products-btn')
                    </div>
                </div>
            </div>

            <!-- Search Drawer -->
            <x-admin::form
                v-slot="{ meta, errors, handleSubmit }"
                as="div"
            >
                <form @submit="handleSubmit($event, addProducts)">
                    <x-admin::drawer
                        ref="addProductsDrawer"
                        @close="searchTerm = ''; searchedProducts = [];"
                    >
                        <!-- Drawer Header -->
                        <x-slot:header class="border-b-0">
                            <div class="grid gap-5">
                                <div class="flex items-center justify-between">
                                    <p class="text-xl font-medium dark:text-white">
                                        @lang('inventory_transfer::app.inventory-transfers.view.items.add-products')
                                    </p>

                                    <button
                                        type="submit"
                                        class="primary-button ltr:mr-11 rtl:ml-11"
                                    >
                                        @lang('inventory_transfer::app.inventory-transfers.view.items.add-btn')
                                    </button>
                                </div>

                                <div class="relative w-full">
                                    <input
                                        type="text"
                                        class="block w-full rounded-lg border bg-white py-1.5 leading-6 text-gray-600 transition-all hover:border-gray-400 ltr:pl-3 ltr:pr-10 rtl:pl-10 rtl:pr-3 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300"
                                        placeholder="Search by name"
                                        v-model.lazy="searchTerm"
                                        v-debounce="500"
                                    />

                                    <template v-if="isSearching">
                                        <x-admin::spinner class="absolute top-2 ltr:right-3 rtl:left-3" />
                                    </template>

                                    <template v-else>
                                        <span class="icon-search pointer-events-none absolute top-1.5 flex items-center text-2xl ltr:right-3 rtl:left-3"></span>
                                    </template>
                                </div>

                                <a
                                    href="{{ route('admin.products.create') }}"
                                    class="w-max cursor-pointer font-semibold text-brandColor"
                                    target="_blank"
                                >
                                    + @lang('inventory_transfer::app.inventory-transfers.view.items.add-new-btn')
                                </a>
                            </div>
                        </x-slot>

                        <!-- Drawer Content -->
                        <x-slot:content class="!p-0">
                            <x-admin::table
                                class="!min-w-max border-x-0"
                                v-if="searchedProducts.length"
                            >
                                <x-admin::table.thead>
                                    <x-admin::table.thead.tr>
                                        <x-admin::table.th class="w-12 !p-3">
                                            <label for="select-all">
                                                <input
                                                    type="checkbox"
                                                    id="select-all"
                                                    class="peer hidden"
                                                    v-model="allSelected"
                                                    @change="selectAll"
                                                >
                                                
                                                <span class='icon-checkbox-outline peer-checked:icon-checkbox-select cursor-pointer rounded-md text-2xl peer-checked:text-brandColor'></span>
                                            </label>
                                        </x-admin::table.th>

                                        <x-admin::table.th class="!p-3">
                                            @lang('inventory_transfer::app.inventory-transfers.view.items.products')
                                        </x-admin::table.th>

                                        <x-admin::table.th class="!p-3">
                                            @lang('inventory_transfer::app.inventory-transfers.view.items.inventories')
                                        </x-admin::table.th>
                                    </x-admin::table.thead.tr>
                                </x-admin::table.thead>

                                <x-admin::table.tbody>
                                    <template v-for="product in searchedProducts">
                                        <x-admin::table.tbody.tr>
                                            <!-- Select Checkbox -->
                                            <x-admin::table.td class="!p-3">
                                                <label :for="'product_' + product.id">
                                                    <input
                                                        type="checkbox"
                                                        :id="'product_' + product.id"
                                                        class="peer hidden"
                                                        v-model="product.selected"
                                                        @change="updateAllSelected"
                                                    >
                                                    
                                                    <span class='icon-checkbox-outline peer-checked:icon-checkbox-select cursor-pointer rounded-md text-2xl peer-checked:text-brandColor'></span>
                                                </label>
                                            </x-admin::table.td>

                                            <!-- Product Information -->
                                            <x-admin::table.td class="flex flex-col gap-1 !p-3">
                                                <a
                                                    :href="'{{ route('admin.products.view', '') }}/' + product.id"
                                                    class="truncate font-medium text-brandColor"
                                                    :title="product.name"
                                                    target="_blank"
                                                >
                                                    @{{ product.name }}
                                                </a>

                                                <span>
                                                    @lang('inventory_transfer::app.inventory-transfers.view.items.sku'):

                                                    @{{ product.sku }}
                                                </span>
                                            </x-admin::table.td>

                                            <!-- Cost Price -->
                                            <x-admin::table.td class="!p-3">
                                                <div class="flex flex-col gap-1">
                                                    <template v-if="product.selected && ! product.addedInventories?.length">
                                                        <x-admin::form.control-group.control
                                                            type="hidden"
                                                            ::name="'products[' + product.id + ']'"
                                                            rules="required"
                                                            label="{{ trans('inventory_transfer::app.inventory-transfers.view.items.qty') }}"
                                                        />

                                                        <v-error-message
                                                            :name="'products[' + product.id + ']'"
                                                            v-slot="{ message }"
                                                        >
                                                            <p
                                                                class="mt-1 whitespace-normal text-xs italic text-red-600"
                                                                v-text="message"
                                                            >
                                                            </p>
                                                        </v-error-message>
                                                    </template>

                                                    <div
                                                        class="flex flex-col items-start gap-2"
                                                        v-for="(addedInventory, index) in product.addedInventories ?? []"
                                                    >
                                                        <div class="flex gap-2">
                                                            <x-admin::form.control-group class="!mb-0 w-28">
                                                                <x-admin::form.control-group.control
                                                                    type="text"
                                                                    class="w-28"
                                                                    ::name="'products[' + product.id + '][' + addedInventory.location.id + '].qty'"
                                                                    ::rules="{required: product.selected, numeric: true, min_value: 0, max_value: addedInventory.on_hand}"
                                                                    v-model="addedInventory.qty"
                                                                    @change="removeAddedInventoryIfZero(product, addedInventory)"
                                                                    label="{{ trans('inventory_transfer::app.inventory-transfers.view.items.qty') }}"
                                                                    ::disabled="!product.selected"
                                                                />
                                                            </x-admin::form.control-group>

                                                            <span class="text-wrap mt-2">
                                                                @{{ "@lang('inventory_transfer::app.inventory-transfers.view.items.from-location', ['location' => 'location'])".replace('location', addedInventory.location.name) }}
                                                            </span>
                                                        </div>

                                                        <v-error-message
                                                            :name="'products[' + product.id + '][' + addedInventory.location.id + '].qty'"
                                                            v-slot="{ message }"
                                                        >
                                                            <p
                                                                class="mt-1 whitespace-normal text-xs italic text-red-600"
                                                                v-text="message"
                                                            >
                                                            </p>
                                                        </v-error-message>
                                                    </div>

                                                    <!-- Add Location -->
                                                    <div v-if="remainingInventories(product).length">
                                                        <x-admin::dropdown position="bottom-right">
                                                            <x-slot:toggle>
                                                                <button
                                                                    type="button"
                                                                    class="text-md cursor-pointer font-semibold text-brandColor dark:text-brandColor"
                                                                    :disabled="!product.selected"
                                                                >
                                                                    + @lang('inventory_transfer::app.inventory-transfers.view.items.add-location')
                                                                </button>
                                                            </x-slot>

                                                            <x-slot:menu>
                                                                <x-admin::dropdown.menu.item
                                                                    v-for="inventory in remainingInventories(product)"
                                                                    @click="addInventory(product, inventory)"
                                                                >
                                                                    @{{ inventory.location.name }}

                                                                </x-admin::dropdown.menu.item>
                                                            </x-slot>
                                                        </x-admin::dropdown>
                                                    </div>
                                                </div>
                                            </x-admin::table.td>
                                        </x-admin::table.thead.tr>
                                    </template>
                                </x-admin::table.tbody>
                            </x-admin::table>

                            <div
                                class="grid justify-center justify-items-center gap-3.5 py-12"
                                v-else
                            >
                                <img
                                    class="dark:mix-blend-exclusion dark:invert" 
                                    src="{{ vite()->asset('images/empty-placeholders/products.svg') }}"
                                >
                                
                                <div class="flex flex-col items-center gap-2">
                                    <p class="text-xl font-semibold dark:text-white">
                                        @lang('inventory_transfer::app.inventory-transfers.view.items.empty-title')
                                    </p>
                                    
                                    <p class="text-gray-400 dark:text-gray-400">
                                        @lang('inventory_transfer::app.inventory-transfers.view.items.search-empty-info')
                                    </p>
                                </div>
                            </div>
                        </x-slot>
                    </x-admin::drawer>
                </form>
            </x-admin::form>
        </div>
    </script>

    <script type="module">
        app.component('v-inventory-transfer-items', {
            template: '#v-inventory-transfer-items-template',

            data() {
                return {
                    inventoryTransfer: @json($inventoryTransfer),
                    
                    searchTerm: '',

                    allSelected: false,

                    searchedProducts: [],

                    isSearching: false,
                }
            },

            computed: {
                selectedProductsCount() {
                    return this.searchedProducts.filter(product => product.selected).length;
                },
            },

            watch: {
                searchTerm(newVal, oldVal) {
                    this.search();
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

                search() {
                    if (this.searchTerm.length <= 1) {
                        this.searchedProducts = [];

                        return;
                    }

                    this.isSearching = true;

                    let self = this;

                    this.$axios.get("{{ route('admin.warehouses.products.search', $inventoryTransfer->from_warehouse_id) }}", {
                            params: {
                                search: 'name:' + this.searchTerm,
                                searchFields: 'name:like',
                            }
                        })
                        .then(function(response) {
                            self.isSearching = false;
                            
                            self.searchedProducts = response.data.data.filter(product => !self.inventoryTransfer.items.find(item => item.product_id === product.id));
                        })
                        .catch(function (error) {
                            console.log(error)
                        });
                },

                selectAll() {
                    for (let product of this.searchedProducts) {
                        product.selected = this.allSelected;
                    }
                },

                updateAllSelected() {
                    this.allSelected = this.searchedProducts.every(product => product.selected);
                },

                addProducts(params) {
                    const selectedProducts = this.searchedProducts.flatMap(product => product.selected ? {'id': product.id, 'inventories': Object.assign({}, params['products'][product.id] ?? [])} : []);

                    let self = this;
                    
                    this.$axios.post("{{ route('admin.inventory_transfers.products.store', $inventoryTransfer->id) }}", {'products': selectedProducts})
                        .then(function(response) {
                            self.$refs.addProductsDrawer.close();

                            self.searchedProducts = [];

                            self.searchTerm = '';

                            self.getInventoryTransfer();
                            
                            self.$emit('items-added');

                            self.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                        })
                        .catch(function (error) {
                            self.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                        });
                },

                remove(item) {
                    let self = this;
                    
                    this.$emitter.emit('open-confirm-modal', {
                        agree: () => {
                            this.$axios.delete("{{ route('admin.inventory_transfers.items.delete', $inventoryTransfer->id) }}", {
                                data: {
                                    items: [item.id]
                                }
                            })
                                .then(function(response) {
                                    self.getInventoryTransfer();

                                    self.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                                    self.$emit('items-removed');
                                })
                                .catch(function (error) {
                                    self.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                                });
                        }
                    });
                },

                remainingInventories(product) {
                    return product.inventories.filter(inventory => !product.addedInventories?.find(location => location.id === inventory.id));
                },

                removeAddedInventoryIfZero(product, inventory) {
                    if (inventory.qty < 1) {
                        product.addedInventories = product.addedInventories.filter(location => location.id !== inventory.id);
                    }
                },

                addInventory(product, inventory) {
                    if (!product.addedInventories) {
                        product.addedInventories = [];
                    }
                    
                    product.addedInventories.push({
                        id: inventory.id,
                        location: inventory.location,
                        on_hand: inventory.on_hand,
                        qty: 1
                    });
                },
            },
        });
    </script>
@endpush