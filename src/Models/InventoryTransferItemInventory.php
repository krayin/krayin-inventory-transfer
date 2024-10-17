<?php

namespace Webkul\InventoryTransfer\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\InventoryTransfer\Contracts\InventoryTransferItemInventory as InventoryTransferItemInventoryContract;
use Webkul\Warehouse\Models\LocationProxy;

class InventoryTransferItemInventory extends Model implements InventoryTransferItemInventoryContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qty_requested',
        'qty_picked',
        'qty_received',
        'warehouse_location_id',
        'inventory_transfer_item_id',
    ];

    /**
     * Get the from warehouse location record associated with the inventory transfer item.
     */
    public function location()
    {
        return $this->belongsTo(LocationProxy::modelClass(), 'warehouse_location_id');
    }

    /**
     * Get the inventory transfer record associated with the inventory transfer item.
     */
    public function inventory_transfer_item()
    {
        return $this->belongsTo(InventoryTransferItemProxy::modelClass());
    }
}
