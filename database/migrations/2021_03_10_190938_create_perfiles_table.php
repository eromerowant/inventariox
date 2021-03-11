<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilesTable extends Migration
{
    public function up()
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('perfil');
            $table->tinyInteger('status')->default(1)->comment('1 is active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perfiles');
    }
}
