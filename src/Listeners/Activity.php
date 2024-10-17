<?php

namespace Webkul\InventoryTransfer\Listeners;

use Webkul\Activity\Contracts\Activity as ActivityContract;
use Webkul\InventoryTransfer\Repositories\InventoryTransferRepository;

class Activity
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected InventoryTransferRepository $inventoryTransferRepository) {}

    /**
     * Link activity to lead or person.
     */
    public function afterUpdateOrCreate(ActivityContract $activity): void
    {
        if (request()->input('inventory_transfer_id')) {
            $inventoryTransfer = $this->inventoryTransferRepository->find(request()->input('inventory_transfer_id'));

            if (! $inventoryTransfer->activities->contains($activity->id)) {
                $inventoryTransfer->activities()->attach($activity->id);
            }
        }
    }
}
