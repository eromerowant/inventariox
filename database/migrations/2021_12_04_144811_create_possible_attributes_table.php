<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('possible_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('possible_entity_id')->nullable();
            $table->foreign('possible_entity_id')->references('id')->on('possible_entities')->onDelete('set null');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('possible_attributes');
    }
}
