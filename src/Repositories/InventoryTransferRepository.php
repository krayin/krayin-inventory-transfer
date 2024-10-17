<?php

namespace Webkul\InventoryTransfer\Repositories;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\DB;
use Webkul\Attribute\Repositories\AttributeValueRepository;
use Webkul\Core\Eloquent\Repository;
use Webkul\InventoryTransfer\Enums\InventoryTransferStatus;

class InventoryTransferRepository extends Repository
{
    /**
     * Searchable fields
     */
    protected $fieldSearchable = [
        'increment_id',
        'reference_number',
        'status',
        'shipping_method',
        'tracking_number',
        'expected_transfer_date',
        'total_items_count',
        'total_qty_requested',
        'total_qty_picked',
        'total_qty_received',
        'created_by_user_id',
        'assigned_to_user_id',
        'from_warehouse_id',
        'to_warehouse_id',
    ];

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeValueRepository $attributeValueRepository,
        protected InventoryTransferItemRepository $inventoryTransferItemRepository,
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
        return 'Webkul\InventoryTransfer\Contracts\InventoryTransfer';
    }

    /**
     * @return \Webkul\InventoryTransfer\Contracts\InventoryTransfer
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $inventoryTransfer = parent::create(array_merge($data, [
                'status'       => InventoryTransferStatus::PENDING,
                'increment_id' => $this->getNextIncrementId(),
            ]));

            $this->attributeValueRepository->save(array_merge($data, [
                'entity_id' => $inventoryTransfer->id,
            ]));
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

        return $inventoryTransfer;
    }

    /**
     * @param  int  $id
     * @param  array  $attributes
     * @return \Webkul\InventoryTransfer\Contracts\InventoryTransfer
     */
    public function update(array $data, $id, $attributes = [])
    {
        $inventoryTransfer = parent::update($data, $id);

        $this->attributeValueRepository->save(array_merge($data, [
            'entity_id' => $inventoryTransfer->id,
        ]));

        if (
            $inventoryTransfer->status == InventoryTransferStatus::INVENTORY_PARTIALLY_PICKED
            || $inventoryTransfer->status == InventoryTransferStatus::INVENTORY_PICKED
        ) {
            $this->pickInventories($data, $inventoryTransfer);
        }

        if (
            $inventoryTransfer->status == InventoryTransferStatus::INVENTORY_PARTIALLY_RECEIVED
            || $inventoryTransfer->status == InventoryTransferStatus::INVENTORY_RECEIVED
        ) {
            $this->receiveInventories($data, $inventoryTransfer);
        }

        return $inventoryTransfer;
    }

    /**
     * Pick inventories for the inventory transfer.
     *
     * @param  array  $data
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransfer  $inventoryTransfer
     * @return void
     */
    public function pickInventories($data, $inventoryTransfer)
    {
        if (! isset($data['items'])) {
            return;
        }

        foreach ($data['items'] as $itemId => $itemInventories) {
            $this->inventoryTransferItemRepository->pickInventories($itemInventories, $itemId);
        }
    }

    /**
     * After inventory transfer is updated
     *
     * @param  array  $data
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransfer  $inventoryTransfer
     * @return void
     */
    public function receiveInventories($data, $inventoryTransfer)
    {
        if (! isset($data['items'])) {
            return;
        }

        foreach ($data['items'] as $itemId => $itemInventories) {
            $this->inventoryTransferItemRepository->receiveInventories($itemInventories, $itemId);
        }
    }

    /**
     * Generate next increment id
     *
     * @return int
     */
    public function getNextIncrementId()
    {
        $lastInventoryTransfer = $this->latest()->first();

        $nextIncrementId = 1;

        if ($lastInventoryTransfer) {
            return $lastInventoryTransfer->id + $nextIncrementId;
        }

        return $nextIncrementId;
    }

    /**
     * Collect totals.
     *
     * @param  \Webkul\InventoryTransfer\Contracts\InventoryTransfer  $inventoryTransfer
     * @return self
     */
    public function collectTotals($inventoryTransfer)
    {
        $inventoryTransfer->fill([
            'total_items_count'   => 0,
            'total_qty_requested' => 0,
            'total_qty_picked'    => 0,
            'total_qty_received'  => 0,
        ]);

        foreach ($inventoryTransfer->items as $item) {
            $inventoryTransfer->total_qty_requested += $item->qty_requested;

            $inventoryTransfer->total_qty_picked += $item->qty_picked;

            $inventoryTransfer->total_qty_received += $item->qty_received;

            $inventoryTransfer->total_items_count += 1;
        }

        $inventoryTransfer->save();

        return $this;
    }
}
