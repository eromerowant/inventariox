<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleEntitiesTable extends Migration
{
    public function up()
    {
        Schema::create('possible_entities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('possible_entities');
    }
}
