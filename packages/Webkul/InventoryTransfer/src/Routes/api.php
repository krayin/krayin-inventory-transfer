<?php

use Illuminate\Support\Facades\Route;
use Webkul\InventoryTransfer\Http\Controllers\InventoryTransferController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::controller(InventoryTransferController::class)->prefix('inventory-transfers')->group(function () {
        Route::put('edit/{id}', 'update')->name('api.admin.inventory_transfers.update');

        Route::get('get/{id}', 'get')->name('api.admin.inventory_transfers.get');

        Route::get('search', 'search')->name('api.admin.inventory_transfers.search');
    });
});
