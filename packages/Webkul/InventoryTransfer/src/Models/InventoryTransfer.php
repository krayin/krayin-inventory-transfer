<?php

namespace Webkul\InventoryTransfer\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Activity\Models\ActivityProxy;
use Webkul\Activity\Traits\LogsActivity;
use Webkul\Attribute\Traits\CustomAttribute;
use Webkul\InventoryTransfer\Contracts\InventoryTransfer as InventoryTransferContract;
use Webkul\InventoryTransfer\Enums\InventoryTransferStatus;
use Webkul\User\Models\UserProxy;
use Webkul\Warehouse\Models\WarehouseProxy;

class InventoryTransfer extends Model implements InventoryTransferContract
{
    use CustomAttribute, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'increment_id',
        'reference_number',
        'status',
        'pick_description',
        'load_description',
        'shipping_method',
        'tracking_number',
        'expected_transfer_date',
        'total_items_count',
        'total_qty_requested',
        'total_qty_picked',
        'total_qty_received',
        'from_warehouse_id',
        'to_warehouse_id',
        'created_by_user_id',
        'assigned_to_user_id',
    ];

    /**
     * The attributes that are castable.
     *
     * @var array
     */
    protected $casts = [
        'status' => InventoryTransferStatus::class,
    ];

    /**
     * Get the items record associated with the inventory transfer.
     */
    public function items()
    {
        return $this->hasMany(InventoryTransferItemProxy::modelClass());
    }

    /**
     * Get the from warehouse record associated with the inventory transfer item.
     */
    public function from_warehouse()
    {
        return $this->belongsTo(WarehouseProxy::modelClass(), 'from_warehouse_id');
    }

    /**
     * Get the to warehouse record associated with the inventory transfer item.
     */
    public function to_warehouse()
    {
        return $this->belongsTo(WarehouseProxy::modelClass(), 'to_warehouse_id');
    }

    /**
     * Get the creator user associated with the inventory transfer.
     */
    public function created_by()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'created_by_user_id');
    }

    /**
     * Get the assigned user associated with the inventory transfer.
     */
    public function assigned_to()
    {
        return $this->belongsTo(UserProxy::modelClass(), 'assigned_to_user_id');
    }

    /**
     * Get the activities.
     */
    public function activities()
    {
        return $this->belongsToMany(ActivityProxy::modelClass(), 'inventory_transfer_activities');
    }

    /**
     * Convert value if json.
     */
    protected static function decodeValueIfJson($value)
    {
        if ($value instanceof InventoryTransferStatus) {
            return $value->value;
        }

        if (
            ! is_array($value)
            && json_decode($value, true)
        ) {
            $value = json_decode($value, true);
        }

        if (! is_array($value)) {
            return $value;
        }

        self::ksortRecursive($value);

        return $value;
    }
}
