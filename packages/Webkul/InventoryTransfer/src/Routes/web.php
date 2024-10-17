<?php

use Illuminate\Support\Facades\Route;
use Webkul\InventoryTransfer\Http\Controllers\InventoryTransferController;
use Webkul\InventoryTransfer\Http\Controllers\WarehouseController;

Route::group([
    'middleware' => [
        'web',
        'admin_locale',
    ],
    'prefix' => config('app.admin_path'),
], function () {
    Route::group(['middleware' => ['user']], function () {
        /**
         * Inventory Transfer routes.
         */
        Route::controller(InventoryTransferController::class)->prefix('inventory-transfers')->group(function () {
            Route::get('', 'index')->name('admin.inventory_transfers.index');

            Route::post('create', 'store')->name('admin.inventory_transfers.store');

            Route::put('edit/{id}', 'update')->name('admin.inventory_transfers.update');

            Route::get('view/{id}', 'view')->name('admin.inventory_transfers.view');

            Route::get('get/{id}', 'get')->name('admin.inventory_transfers.get');

            Route::get('search', 'search')->name('admin.inventory_transfers.search');

            Route::get('{id}/activities', 'activities')->name('admin.inventory_transfers.activities.index');

            Route::post('products/{id}', 'storeProducts')->name('admin.inventory_transfers.products.store');

            Route::delete('items/{id}', 'removeItems')->name('admin.inventory_transfers.items.delete');

            Route::delete('{id}', 'destroy')->name('admin.inventory_transfers.delete');

            Route::get('print/{id}', 'print')->name('admin.inventory_transfers.print');
        });

        Route::controller(WarehouseController::class)->prefix('warehouses')->group(function () {
            Route::get('{id}/products', 'products')->name('admin.warehouses.products.search');
        });
    });
});
