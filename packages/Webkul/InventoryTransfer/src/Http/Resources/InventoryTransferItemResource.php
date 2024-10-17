<?php

namespace Webkul\InventoryTransfer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryTransferItemResource extends JsonResource
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
            'id'             => $this->id,
            'product_id'     => $this->product_id,
            'sku'            => $this->sku,
            'name'           => $this->name,
            'qty_requested'  => $this->qty_requested,
            'qty_picked'     => $this->qty_picked,
            'qty_received'   => $this->qty_received,
            'inventories'    => InventoryTransferItemInventoryResource::collection($this->inventories),
            'from_locations' => WarehouseLocationResource::collection($this->product->locations->where('warehouse_id', $this->inventory_transfer->from_warehouse_id)),
            'to_locations'   => WarehouseLocationResource::collection($this->product->locations->where('warehouse_id', $this->inventory_transfer->to_warehouse_id)),
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
