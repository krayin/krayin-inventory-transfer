<?php

namespace Webkul\InventoryTransfer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Admin\Http\Resources\UserResource;

class InventoryTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                     => $this->id,
            'increment_id'           => $this->increment_id,
            'reference_number'       => $this->reference_number,
            'status'                 => $this->status,
            'pick_description'       => $this->pick_description,
            'load_description'       => $this->load_description,
            'shipping_method'        => $this->shipping_method,
            'tracking_number'        => $this->tracking_number,
            'expected_transfer_date' => $this->expected_transfer_date,
            'total_items_count'      => $this->total_items_count,
            'total_qty_requested'    => $this->total_qty_requested,
            'total_qty_picked'       => $this->total_qty_picked,
            'total_qty_received'     => $this->total_qty_received,
            'from_warehouse'         => new WarehouseResource($this->from_warehouse),
            'to_warehouse'           => new WarehouseResource($this->to_warehouse),
            'created_by'             => new UserResource($this->created_by),
            'assigned_to'            => new UserResource($this->assigned_to),
            'items'                  => InventoryTransferItemResource::collection($this->items),
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
        ];
    }
}
