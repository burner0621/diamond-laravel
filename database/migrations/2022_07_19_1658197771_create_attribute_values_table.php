<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {

		$table->id();
		$table->integer('attribute_id',);
		$table->string('name');
		$table->string('value');
		$table->string('slug')->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
}