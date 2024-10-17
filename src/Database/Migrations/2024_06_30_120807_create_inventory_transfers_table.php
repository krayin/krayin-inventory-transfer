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
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('increment_id')->unique();
            $table->string('reference_number')->nullable();
            $table->string('status');
            $table->text('pick_description')->nullable();
            $table->text('load_description')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('tracking_number')->nullable();
            $table->date('expected_transfer_date')->nullable();
            $table->integer('total_items_count')->default(0);
            $table->integer('total_qty_requested')->default(0);
            $table->integer('total_qty_picked')->default(0);
            $table->integer('total_qty_received')->default(0);

            $table->integer('created_by_user_id')->unsigned()->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->integer('assigned_to_user_id')->unsigned()->nullable();
            $table->foreign('assigned_to_user_id')->references('id')->on('users')->onDelete('SET NULL');

            $table->integer('from_warehouse_id')->unsigned()->nullable();
            $table->foreign('from_warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');

            $table->integer('to_warehouse_id')->unsigned()->nullable();
            $table->foreign('to_warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfers');
    }
};
