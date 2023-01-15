<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {

		$table->id();
		$table->integer('parent_id',)->nullable();
		$table->string('category_name');
		$table->string('category_excerpt')->nullable();
		$table->string('slug');
        $table->string('meta_title')->nullable();
		$table->text('meta_description')->nullable();
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
