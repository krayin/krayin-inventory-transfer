<?php

namespace Webkul\InventoryTransfer\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Webkul\Product\Repositories\ProductInventoryRepository;

class InventoryTransferItemRepository extends Repository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected InventoryTransferItemInventoryRepository $inventoryTransferItemInventoryRepository,
        protected ProductInventoryRepository $productInventoryRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\InventoryTransfer\Contracts\InventoryTransferItem';
    }

    /**
     * @return \Webkul\InventoryTransfer\Contracts\InventoryTransferItem
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $inventoryTransferItem = parent::create($data);

            foreach ($data['inventories'] as $locationId => $inventoryData) {
                if (empty($inventoryData['qty'])) {
                    continue;
                }

                $this->inventoryTransferItemInventoryRepository->create([
                    'qty_requested'              => $inventoryData['qty'],
                    'warehouse_location_id'      => $locationId,
                    'inventory_transfer_item_id' => $inventoryTransferItem->id,
                ]);
            }
        } catch (\Exception $e) {
            /**
             * Rolling back the transaction
             */
            DB::rollBack();

            /**
             * Call again to create order
             */
            $this->create($data);
        } finally {
            /**
             * Committing the transaction
             */
            DB::commit();
        }

        return $inventoryTransferItem;
    }

    /**
     * Collect totals.
     *
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransferItem  $InventoryTransferItem
     * @return self
     */
    public function collectTotals($inventoryTransferItem)
    {
        $inventoryTransferItem->fill([
            'qty_requested' => 0,
            'qty_picked'    => 0,
            'qty_received'  => 0,
        ]);

        foreach ($inventoryTransferItem->inventories as $inventory) {
            $inventoryTransferItem->qty_requested += $inventory->qty_requested;

            $inventoryTransferItem->qty_picked += $inventory->qty_picked;

            $inventoryTransferItem->qty_received += $inventory->qty_received;
        }

        $inventoryTransferItem->save();

        return $this;
    }

    /**
     * Pick inventories for the inventory transfer.
     *
     * @param  array  $data
     * @param  int  $id
     * @return void
     */
    public function pickInventories($data, $id)
    {
        $inventoryTransferItem = parent::find($id);

        $quantityPicked = 0;

        foreach ($data as $locationId => $locationInventory) {
            if (! $locationInventory['qty_picked']) {
                continue;
            }

            $productInventory = $this->productInventoryRepository->findOneWhere([
                'product_id'            => $inventoryTransferItem->product_id,
                'warehouse_id'          => $inventoryTransferItem->inventory_transfer->from_warehouse_id,
                'warehouse_location_id' => $locationId,
            ]);

            if ($productInventory) {
                $this->productInventoryRepository->update([
                    'in_stock' => $productInventory->in_stock - $locationInventory['qty_picked'],
                ], $productInventory->id);
            }

            $inventoryTransferItemInventory = $this->inventoryTransferItemInventoryRepository->findOneWhere([
                'warehouse_location_id'      => $locationId,
                'inventory_transfer_item_id' => $inventoryTransferItem->id,
            ]);

            if ($inventoryTransferItemInventory) {
                $this->inventoryTransferItemInventoryRepository->update([
                    'qty_picked' => $inventoryTransferItemInventory->qty_picked + $locationInventory['qty_picked'],
                ], $inventoryTransferItemInventory->id);
            }

            $quantityPicked += $locationInventory['qty_picked'];
        }

        parent::update([
            'qty_picked' => $inventoryTransferItem->qty_picked + $quantityPicked,
        ], $id);
    }

    /**
     * Receive inventories for the inventory transfer.
     *
     * @param  array  $data
     * @param  int  $id
     * @return void
     */
    public function receiveInventories($data, $id)
    {
        $inventoryTransferItem = parent::find($id);

        $quantityReceived = 0;

        foreach ($data as $locationInventory) {
            if (! $locationInventory['qty_received']) {
                continue;
            }

            $productInventory = $this->productInventoryRepository->findOneWhere([
                'product_id'            => $inventoryTransferItem->product_id,
                'warehouse_id'          => $inventoryTransferItem->inventory_transfer->to_warehouse_id,
                'warehouse_location_id' => $locationInventory['location_id'],
            ]);

            if ($productInventory) {
                $this->productInventoryRepository->update([
                    'in_stock' => $productInventory->in_stock + $locationInventory['qty_received'],
                ], $productInventory->id);
            } else {
                $this->productInventoryRepository->create([
                    'product_id'            => $inventoryTransferItem->product_id,
                    'warehouse_id'          => $inventoryTransferItem->inventory_transfer->to_warehouse_id,
                    'warehouse_location_id' => $locationInventory['location_id'],
                    'in_stock'              => $locationInventory['qty_received'],
                ]);
            }

            $inventoryTransferItemInventory = $this->inventoryTransferItemInventoryRepository->findOneWhere([
                'warehouse_location_id'      => $locationInventory['location_id'],
                'inventory_transfer_item_id' => $inventoryTransferItem->id,
            ]);

            if ($inventoryTransferItemInventory) {
                $this->inventoryTransferItemInventoryRepository->update([
                    'qty_received' => $inventoryTransferItemInventory->qty_received + $locationInventory['qty_received'],
                ], $inventoryTransferItemInventory->id);
            } else {
                $this->inventoryTransferItemInventoryRepository->create([
                    'qty_received'               => $locationInventory['qty_received'],
                    'warehouse_location_id'      => $locationInventory['location_id'],
                    'inventory_transfer_item_id' => $inventoryTransferItem->id,
                ]);
            }

            $quantityReceived += $locationInventory['qty_received'];
        }

        parent::update([
            'qty_received' => $inventoryTransferItem->qty_received + $quantityReceived,
        ], $id);
    }
}
