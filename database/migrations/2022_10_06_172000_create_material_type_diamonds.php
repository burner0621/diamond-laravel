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
        Schema::create('material_type_diamonds', function (Blueprint $table) {
            $table->id();
            $table->integer('material_id');
            $table->integer('material_type_id');
            $table->string('mm_size');
            $table->string('xy_size')->nullable();
            $table->string('carat_weight');
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
        Schema::dropIfExists('material_type_diamonds');
    }
};
