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
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('product_attribute_value_id')->default(0);
            $table->integer('material_id');
            $table->integer('material_type_id');
            $table->string('material_weight');
            $table->integer('is_diamond');
            $table->integer('diamond_id');
            $table->string('diamond_amount');
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
        Schema::dropIfExists('product_materials');
    }
};
