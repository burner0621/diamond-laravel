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
        Schema::create('products_variants', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->text("variant_name")->nullable();
            $table->string("variant_attribute_value")->nullable();
            $table->integer("variant_price");
            $table->string("variant_sku")->nullable();
            $table->text("variant_thumbnail")->nullable();
            $table->integer("variant_quantity")->nullable();
            $table->text("variant_assets")->nullable();
            $table->text("digital_download_assets")->nullable();
            $table->integer("digital_download_assets_count")->nullable();
            $table->integer("digital_download_assets_limit")->nullable();
            $table->integer("price_discount")->nullable();
            $table->float("price_discount_type")->nullable();
            $table->dateTime("price_discount_start")->nullable();
            $table->dateTime("price_discount_end")->nullable();
            $table->float("shipping_type")->nullable();
            $table->integer("shipping_cost")->nullable();
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
        Schema::dropIfExists('products_variants');
    }
};
