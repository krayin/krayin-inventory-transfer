<?php

return [
    'inventory_transfers' => [
        'name'   => 'Inventory Transfers',
        'class'  => 'Webkul\InventoryTransfer\Workflows\InventoryTransfer',
        'events' => [
            [
                'event' => 'inventory_transfers.create.after',
                'name'  => 'Created',
            ], [
                'event' => 'inventory_transfers.update.after',
                'name'  => 'Updated',
            ], [
                'event' => 'inventory_transfers.delete.before',
                'name'  => 'Deleted',
            ], [
                'event' => 'inventory_transfers.status.update.after',
                'name'  => 'Status Updated',
            ],
        ],
    ],
];
