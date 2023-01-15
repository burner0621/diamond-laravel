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
        Schema::create('sellers_profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('wallet')->default(0);
            $table->integer('sales_commission_rate')->nullable();
            $table->text('business_name')->nullable();
            $table->text('whatsapp')->nullable();
            $table->text('slogan')->nullable();
            $table->text('about')->nullable();
            $table->unsignedInteger('default_payment_method')->nullable();
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
        Schema::dropIfExists('sellers_profile');
    }
};
