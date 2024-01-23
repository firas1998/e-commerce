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

        if (!Schema::hasTable('cart_product')) {
            Schema::create('cart_product', function (Blueprint $table) {
                $table->id('id');
                $table->unsignedBigInteger('cart_id')->nullable(false);
                $table->unsignedBigInteger('product_id')->nullable(false);
                $table->unsignedBigInteger('color_id')->nullable(false);
                $table->unsignedBigInteger('size_id')->nullable(false);
                $table->foreign('cart_id')->references('id')->on('carts');
                $table->foreign('product_id')->references('id')->on('products');
                $table->foreign('color_id')->references('id')->on('colors');
                $table->foreign('size_id')->references('id')->on('sizes');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_product');
    }
};
