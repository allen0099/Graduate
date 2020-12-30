<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreignId('item_id')->references('id')->on('items')->cascadeOnDelete();

            $table->unsignedInteger('quantity');

            $table->unique(['order_id', 'item_id'], 'item_in_order_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
