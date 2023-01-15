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
        Schema::create('seller_edit_products', function (Blueprint $table) {
            $table->id();
            $table->integer('is_approved')->default(0); //0 pending, 1 approved;
            $table->integer('product_id');
            $table->integer('status',)->nullable(); //1 active , 2 pending review, 3 draft, 4 denied, 5 archived.
            $table->integer('vendor',)->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price',);
            $table->smallInteger('quantity',)->nullable();
            $table->string('category',24);
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->integer('price_discount',)->nullable();
            $table->string('price_discount_type')->nullable();
            $table->datetime('price_discount_start')->nullable();
            $table->datetime('price_discount_end')->nullable();
            $table->string('shipping_type')->nullable();
            $table->integer('shipping_cost',)->nullable();
            $table->integer('is_digital',)->nullable();
            $table->integer('is_virtual',)->nullable();
            $table->integer('is_trackingquantity',)->nullable();
            $table->integer('is_backorder',)->nullable();
            $table->integer('is_madetoorder',)->nullable();
            $table->integer('tax_option_id',)->default(0);
            $table->string('product_thumbnail')->nullable();
            $table->text('product_images')->nullable();
            $table->text('product_3dpreview')->nullable();
            $table->string('product_3dpreview_xyz',)->nullable();
            $table->text('digital_download_assets')->nullable();
            $table->integer('digital_download_assets_count',)->nullable();
            $table->integer('digital_download_assets_limit',)->nullable();
            $table->string('product_attributes')->nullable();
            $table->string('product_attribute_values')->nullable();
            $table->integer('step_type')->default(0);
            $table->integer('step_group')->nullable()->default(0);
            $table->string('steps')->nullable()->default('');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->datetime('published_at')->nullable();
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
        Schema::dropIfExists('seller_edit_products');
    }
};
