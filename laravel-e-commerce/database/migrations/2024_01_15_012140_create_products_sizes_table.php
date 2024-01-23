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

        if (!Schema::hasTable('products_sizes')) {
            Schema::create('products_sizes', function (Blueprint $table) {
                $table->id('id');
                $table->unsignedBigInteger('size_id')->nullable(false);
                $table->unsignedBigInteger('product_id')->nullable(false);
                $table->foreign('size_id')->references('id')->on('sizes');
                $table->foreign('product_id')->references('id')->on('products');
                $table->unique(['size_id', 'product_id']);
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
        Schema::dropIfExists('products_sizes');
    }
};
