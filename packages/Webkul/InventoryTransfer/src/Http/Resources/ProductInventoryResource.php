<?php

namespace Webkul\InventoryTransfer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductInventoryResource extends JsonResource
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
            'id'           => $this->id,
            'in_stock'     => $this->in_stock,
            'allocated'    => $this->allocated,
            'on_hand'      => $this->on_hand,
            'warehouse'    => new WarehouseResource($this->warehouse),
            'location'     => new WarehouseLocationResource($this->location),
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
