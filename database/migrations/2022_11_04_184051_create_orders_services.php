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
        Schema::create('orders_services', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0); // 0-pending, 1 = in progress, 2-revision, 3-canceled, 4-(physical:delivered) 5-completed
            $table->string('order_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->string('service_name');
            $table->string('package_name');
            $table->string('package_description');
            $table->string('package_price');
            $table->integer('package_delivery_time');
            $table->string('revisions');
            $table->dateTime('original_delivery_time');
            $table->dateTime('extended_delivery_time');
            $table->string('payment_intent')->default('');
            $table->smallInteger('status_payment')->default(1); // 1: unpaid, 2: paid
            $table->string('status_payment_reason')->default('');
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
        Schema::dropIfExists('orders_services');
    }
};
