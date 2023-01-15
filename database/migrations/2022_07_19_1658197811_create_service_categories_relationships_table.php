<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCategoriesRelationshipsTable extends Migration
{
    public function up()
    {
        Schema::create('service_categories_relationships', function (Blueprint $table) {

		$table->id();
		$table->integer('id_post',);
		$table->integer('id_category',);
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('service_categories_relationships');
    }
}
