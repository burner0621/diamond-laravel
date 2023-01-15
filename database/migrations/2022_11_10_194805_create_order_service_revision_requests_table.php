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
        Schema::create('order_service_revision_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("order_id");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("delivery_id");
            $table->text("message");
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
        Schema::dropIfExists('order_service_revision_requests');
    }
};