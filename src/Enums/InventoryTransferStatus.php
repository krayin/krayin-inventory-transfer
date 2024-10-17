<?php

namespace Webkul\InventoryTransfer\Enums;

enum InventoryTransferStatus: string
{
    case PENDING = 'pending';

    case INVENTORY_PARTIALLY_PICKED = 'inventory_partially_picked';

    case INVENTORY_PICKED = 'inventory_picked';

    case INVENTORY_LOADED = 'inventory_load';

    case INVENTORY_IN_TRANSIT = 'inventory_in_transit';

    case INVENTORY_PARTIALLY_RECEIVED = 'inventory_partially_received';

    case INVENTORY_RECEIVED = 'inventory_received';

    case CANCELED = 'canceled';

    /**
     * Get the label of the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING                      => trans('inventory_transfer::app.inventory-transfers.status.pending'),
            self::INVENTORY_PARTIALLY_PICKED   => trans('inventory_transfer::app.inventory-transfers.status.partially-picked'),
            self::INVENTORY_PICKED             => trans('inventory_transfer::app.inventory-transfers.status.picked'),
            self::INVENTORY_LOADED             => trans('inventory_transfer::app.inventory-transfers.status.loaded'),
            self::INVENTORY_IN_TRANSIT         => trans('inventory_transfer::app.inventory-transfers.status.in-transit'),
            self::INVENTORY_PARTIALLY_RECEIVED => trans('inventory_transfer::app.inventory-transfers.status.partially-received'),
            self::INVENTORY_RECEIVED           => trans('inventory_transfer::app.inventory-transfers.status.received'),
            self::CANCELED                     => trans('inventory_transfer::app.inventory-transfers.status.canceled'),
        };
    }

    /**
     * Get the index of the status.
     */
    public function index(): string
    {
        return match ($this) {
            self::PENDING                      => 0,
            self::CANCELED                     => 0,
            self::INVENTORY_PARTIALLY_PICKED   => 1,
            self::INVENTORY_PICKED             => 1,
            self::INVENTORY_LOADED             => 2,
            self::INVENTORY_IN_TRANSIT         => 3,
            self::INVENTORY_PARTIALLY_RECEIVED => 4,
            self::INVENTORY_RECEIVED           => 4,
        };
    }
}
