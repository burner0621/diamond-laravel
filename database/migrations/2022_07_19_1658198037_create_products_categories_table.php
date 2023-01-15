<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('products_categories', function (Blueprint $table) {

		$table->id();
		$table->integer('parent_id',)->nullable();
		$table->string('category_name');
		$table->string('slug');
		$table->string('category_excerpt')->nullable();
        $table->string('meta_title')->nullable();
		$table->text('meta_description')->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('products_categories');
    }
}
