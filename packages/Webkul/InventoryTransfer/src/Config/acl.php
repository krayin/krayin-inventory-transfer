<?php

return [
    /**
     * Inventory Transfers ACL
     */
    [
        'key'   => 'inventory_transfers',
        'name'  => 'inventory_transfer::app.acl.inventory-transfers.title',
        'route' => 'admin.inventory_transfers.index',
        'sort'  => 4,
    ], [
        'key'   => 'inventory_transfers.create',
        'name'  => 'inventory_transfer::app.acl.inventory-transfers.create',
        'route' => ['admin.inventory_transfers.create', 'admin.inventory_transfers.store'],
        'sort'  => 1,
    ], [
        'key'   => 'inventory_transfers.view',
        'name'  => 'inventory_transfer::app.acl.inventory-transfers.view',
        'route' => 'admin.inventory_transfers.view',
        'sort'  => 2,
    ], [
        'key'   => 'inventory_transfers.edit',
        'name'  => 'inventory_transfer::app.acl.inventory-transfers.edit',
        'route' => ['admin.inventory_transfers.edit', 'admin.inventory_transfers.update'],
        'sort'  => 3,
    ], [
        'key'   => 'inventory_transfers.delete',
        'name'  => 'inventory_transfer::app.acl.inventory-transfers.delete',
        'route' => ['admin.inventory_transfers.delete'],
        'sort'  => 4,
    ],
];
