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
        Schema::create('material_type_diamonds_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('diamond_id');
            $table->integer('color');
            $table->integer('clarity');
            $table->string('natural_price');
            $table->string('lab_price');
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
        Schema::dropIfExists('material_type_diamonds_prices');
    }
};
