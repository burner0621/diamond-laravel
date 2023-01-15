<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
	public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->integer('status',)->nullable();
            $table->integer('author_id',)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->text('post_excerpt')->nullable();
            $table->integer('thumbnail')->nullable();
            $table->text('post')->nullable();
            $table->integer('tags_id')->nullable();
            $table->integer('categorie_id');
            $table->string('meta_title')->nullable();
		    $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
