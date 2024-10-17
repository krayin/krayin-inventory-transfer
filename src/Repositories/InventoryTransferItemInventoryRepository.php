<?php

namespace Webkul\InventoryTransfer\Repositories;

use Webkul\Core\Eloquent\Repository;

class InventoryTransferItemInventoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\InventoryTransfer\Contracts\InventoryTransferItemInventory';
    }
}
