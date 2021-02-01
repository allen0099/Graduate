<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            // each students only have one set, include a cloth and an accessory
            $table->id();

            $table->foreignId('student_id')->unique()
                ->constrained('users');

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('color_item')
                ->constrained('items');
            $table->foreignId('size_item')
                ->constrained('items');

            $table->foreignId('list_id')
                ->nullable()
                ->constrained('lists');

            $table->date('returned')->nullable();
            $table->boolean('refund')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sets');
    }
}
