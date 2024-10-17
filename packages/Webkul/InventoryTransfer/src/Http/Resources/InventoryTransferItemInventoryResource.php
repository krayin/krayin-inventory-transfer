<?php

namespace Webkul\InventoryTransfer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryTransferItemInventoryResource extends JsonResource
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
            'id'            => $this->id,
            'qty_requested' => $this->qty_requested,
            'qty_picked'    => $this->qty_picked,
            'qty_received'  => $this->qty_received,
            'location'      => new WarehouseLocationResource($this->location),
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
