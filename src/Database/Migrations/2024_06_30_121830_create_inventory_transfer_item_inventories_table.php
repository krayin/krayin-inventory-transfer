<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_transfer_item_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qty_requested')->unsigned()->default(0);
            $table->integer('qty_picked')->unsigned()->default(0);
            $table->integer('qty_received')->unsigned()->default(0);

            $table->integer('warehouse_location_id')->unsigned()->nullable();
            $table->foreign('warehouse_location_id', 'fk_warehouse_location')->references('id')->on('warehouse_locations')->onDelete('restrict');

            $table->integer('inventory_transfer_item_id')->unsigned();
            $table->foreign('inventory_transfer_item_id', 'fk_inventory_transfer_item')->references('id')->on('inventory_transfer_items')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfer_item_inventories');
    }
};
