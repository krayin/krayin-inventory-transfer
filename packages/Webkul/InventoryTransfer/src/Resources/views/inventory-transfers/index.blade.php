<x-admin::layouts>
    <x-slot:title>
        @lang('inventory_transfer::app.inventory-transfers.index.title')
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <div class="flex cursor-pointer items-center">
                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs name="inventory_transfers" />
                </div>

                <div class="text-xl font-bold dark:text-white">
                    @lang('inventory_transfer::app.inventory-transfers.index.title')
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <!-- Create button for Product -->
                @if (bouncer()->hasPermission('purchasing.inventory_transfers.create'))
                    <v-inventory-transfer-create></v-inventory-transfer-create>
                @endif
            </div>
        </div>

        {!! view_render_event('admin.inventory_transfers.index.datagrid.before') !!}

        <!-- DataGrid -->
        <x-admin::datagrid src="{{ route('admin.inventory_transfers.index') }}" />

        {!! view_render_event('admin.inventory_transfers.index.datagrid.after') !!}
    </div>
    
    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-inventory-transfer-create-template"
        >
            <div>
                <button
                    class="primary-button"
                    @click="this.$refs.inventoryTransferCreateModal.toggle()"
                >
                    @lang('inventory_transfer::app.inventory-transfers.index.create-btn')
                </button>
                
                <x-admin::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                    ref="modalForm"
                >
                    <form @submit="handleSubmit($event, create)">
                        {!! view_render_event('admin.inventory_transfers.index.form_controls.before') !!}

                        <x-admin::modal ref="inventoryTransferCreateModal">
                            <!-- Modal Header -->
                            <x-slot:header>
                                <p class="text-lg font-bold text-gray-800 dark:text-white">
                                    @{{ 
                                        selectedType
                                        ? "@lang('inventory_transfer::app.inventory-transfers.index.edit.title')" 
                                        : "@lang('inventory_transfer::app.inventory-transfers.index.create.title')"
                                    }}
                                </p>
                            </x-slot>

                            <!-- Modal Content -->
                            <x-slot:content>
                                {!! view_render_event('admin.inventory_transfers.index.content.before') !!}

                                <!-- From Warehouse -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('inventory_transfer::app.inventory-transfers.index.create.from-warehouse')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="select"
                                        id="from_warehouse_id"
                                        name="from_warehouse_id"
                                        rules="required"
                                        :label="trans('inventory_transfer::app.inventory-transfers.index.create.from-warehouse')"
                                    >
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error control-name="from_warehouse_id" />
                                </x-admin::form.control-group>

                                <!-- To Warehouse -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('inventory_transfer::app.inventory-transfers.index.create.to-warehouse')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="select"
                                        id="to_warehouse_id"
                                        name="to_warehouse_id"
                                        rules="required"
                                        :label="trans('inventory_transfer::app.inventory-transfers.index.create.to-warehouse')"
                                    >
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">
                                                {{ $warehouse->name }}
                                            </option>
                                        @endforeach
                                    </x-admin::form.control-group.control>

                                    <x-admin::form.control-group.error control-name="to_warehouse_id" />
                                </x-admin::form.control-group>

                                <!-- Reference Number -->
                                <x-admin::form.control-group>
                                    <x-admin::form.control-group.label class="required">
                                        @lang('inventory_transfer::app.inventory-transfers.index.create.reference-number')
                                    </x-admin::form.control-group.label>

                                    <x-admin::form.control-group.control
                                        type="text"
                                        id="reference_number"
                                        name="reference_number"
                                        rules="required"
                                        :label="trans('inventory_transfer::app.inventory-transfers.index.create.reference-number')"
                                    />

                                    <x-admin::form.control-group.error control-name="reference_number" />
                                </x-admin::form.control-group>

                                {!! view_render_event('admin.inventory_transfers.index.content.after') !!}
                            </x-slot>

                            <!-- Modal Footer -->
                            <x-slot:footer>
                                <!-- Save Button -->
                                <x-admin::button
                                    button-type="submit"
                                    class="primary-button justify-center"
                                    :title="trans('inventory_transfer::app.inventory-transfers.index.create.save-btn')"
                                    ::loading="isProcessing"
                                    ::disabled="isProcessing"
                                />
                            </x-slot>
                        </x-admin::modal>

                        {!! view_render_event('admin.inventory_transfers.index.form_controls.after') !!}
                    </form>
                </x-admin::form>
            </div>
        </script>

        <script type="module">
            app.component('v-inventory-transfer-create', {
                template: '#v-inventory-transfer-create-template',
        
                data() {
                    return {
                        isProcessing: false,
                    };
                },

                methods: {
                    create(params, {setErrors}) {
                        this.isProcessing = true;

                        this.$axios.post("{{ route('admin.inventory_transfers.store') }}", params)
                            .then(response => {
                                this.isProcessing = false;

                                this.$refs.inventoryTransferCreateModal.toggle();

                                window.location.href = response.data.redirect;
                            }).catch(error => {
                                this.isProcessing = false;

                                if (error.response.status === 422) {
                                    setErrors(error.response.data.errors);
                                }
                            });
                    },
                },
            });
        </script>
    @endPushOnce
</x-admin::layouts>