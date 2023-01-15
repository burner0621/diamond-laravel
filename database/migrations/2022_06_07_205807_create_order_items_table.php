<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('order_id');
            $table->integer('product_id')->nullable();
            $table->string('product_isdigital');
            $table->string('product_isvirtual');
            $table->string('product_name');
            $table->string('product_variant')->nullable();
            $table->string('product_variant_name')->nullable();
            $table->string('product_digital_download_assets')->nullable();
            $table->string('product_thumbnail')->nullable();
            $table->tinyInteger('quantity')->unsigned();
            $table->integer('price')->unsigned();
            $table->smallInteger('status_fulfillment')->default(1); // 1: pending (Physical products - 2: shipped), (Digital products - 3: delivered)
            $table->string('status_tracking')->nullable();
            $table->timestamps();
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
};
