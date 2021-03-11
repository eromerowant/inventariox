<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEjemplaresTable extends Migration
{
    public function up()
    {
        Schema::create('ejemplares', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->longText('atributos');
            $table->integer('cantidad_disponible')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ejemplares');
    }
}
