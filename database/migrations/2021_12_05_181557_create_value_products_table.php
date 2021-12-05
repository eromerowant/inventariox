<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValueProductsTable extends Migration
{
    public function up()
    {
        Schema::create('value_products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('value_id')->nullable();
            $table->foreign('value_id')->references('id')->on('values')->onDelete('set null');

            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('set null');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('value_products');
    }
}
