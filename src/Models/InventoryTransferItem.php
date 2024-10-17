<?php

namespace Webkul\InventoryTransfer\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\InventoryTransfer\Contracts\InventoryTransferItem as InventoryTransferItemContract;
use Webkul\Product\Models\ProductProxy;

class InventoryTransferItem extends Model implements InventoryTransferItemContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'name',
        'qty_requested',
        'qty_picked',
        'qty_received',
        'product_id',
        'inventory_transfer_id',
    ];

    /**
     * Get the product record associated with the inventory transfer item.
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    /**
     * Get the inventory transfer record associated with the inventory transfer item.
     */
    public function inventory_transfer()
    {
        return $this->belongsTo(InventoryTransferProxy::modelClass());
    }

    /**
     * Get the inventory transfer item inventories record associated with the inventory transfer item.
     */
    public function inventories()
    {
        return $this->hasMany(InventoryTransferItemInventoryProxy::modelClass());
    }
}
