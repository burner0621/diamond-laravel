<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagsRelationshipsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_tags_relationships', function (Blueprint $table) {

		$table->id();
		$table->integer('id_post',);
		$table->integer('id_tag',);
		$table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_tags_relationships');
    }
}