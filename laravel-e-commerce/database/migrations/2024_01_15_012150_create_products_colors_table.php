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

        if (!Schema::hasTable('products_colors')) {
            Schema::create('products_colors', function (Blueprint $table) {
                $table->id('id');
                $table->unsignedBigInteger('color_id')->nullable(false);
                $table->unsignedBigInteger('product_id')->nullable(false);
                $table->foreign('color_id')->references('id')->on('colors');
                $table->foreign('product_id')->references('id')->on('products');
                $table->unique(['color_id', 'product_id']);
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
        Schema::dropIfExists('products_colors');
    }
};
