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
        Schema::create('service_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->smallInteger('type')->default(0); // 0-text, 1-attachment, 2-multiple choice
            $table->string('question');
            $table->smallInteger('required')->default(0); // 0: no, 1: yes
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_requirements');
    }
};