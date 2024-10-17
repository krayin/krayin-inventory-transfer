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
        Schema::create('inventory_transfer_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku')->nullable();
            $table->string('name')->nullable();
            $table->integer('qty_requested')->unsigned()->default(0);
            $table->integer('qty_picked')->unsigned()->default(0);
            $table->integer('qty_received')->unsigned()->default(0);

            $table->integer('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('SET NULL');

            $table->integer('inventory_transfer_id')->unsigned();
            $table->foreign('inventory_transfer_id')->references('id')->on('inventory_transfers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfer_items');
    }
};
