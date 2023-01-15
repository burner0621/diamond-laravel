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
        Schema::create('current_rate', function (Blueprint $table) {
            $table->id();
            $table->string('base')->nullable()->default('0');
            $table->string('USD')->nullable()->default('0');
            $table->string('unit')->nullable()->default('0');
            $table->string('XAG')->nullable()->default('0');
            $table->string('XAU')->nullable()->default('0');
            $table->string('XPT')->nullable()->default('0');
            $table->string('24k')->nullable()->default('0');
            $table->string('22k')->nullable()->default('0');
            $table->string('18k')->nullable()->default('0');
            $table->string('14k')->nullable()->default('0');
            $table->string('10k')->nullable()->default('0');
            $table->string('silver_gram')->nullable()->default('0');
            $table->string('platinum_gram')->nullable()->default('0');
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
        Schema::dropIfExists('current_rate');
    }
};
