<?php

namespace Webkul\InventoryTransfer\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\InventoryTransfer\Models\InventoryTransfer::class,
        \Webkul\InventoryTransfer\Models\InventoryTransferItem::class,
        \Webkul\InventoryTransfer\Models\InventoryTransferItemInventory::class,
    ];
}
