<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard > Inventory Transfers
Breadcrumbs::for('inventory_transfers', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('inventory_transfer::app.inventory-transfers.index.title'), route('admin.inventory_transfers.index'));
});

// Dashboard > Inventory Transfers > View Inventory Transfer
Breadcrumbs::for('inventory_transfers.view', function (BreadcrumbTrail $trail, $inventoryTransfer) {
    $trail->parent('inventory_transfers');
    $trail->push('#'.$inventoryTransfer->increment_id, route('admin.inventory_transfers.view', $inventoryTransfer->id));
});

// Dashboard > Inventory Transfers > Edit Inventory Transfer
Breadcrumbs::for('inventory_transfers.edit', function (BreadcrumbTrail $trail, $inventoryTransfer) {
    $trail->parent('inventory_transfers');
    $trail->push(trans('inventory_transfer::app.inventory-transfers.edit-title'), route('admin.inventory_transfers.edit', $inventoryTransfer->id));
});
