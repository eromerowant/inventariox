<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleValuesTable extends Migration
{
    public function up()
    {
        Schema::create('possible_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('possible_attribute_id')->nullable();
            $table->foreign('possible_attribute_id')->references('id')->on('possible_attributes')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('possible_values');
    }
}
