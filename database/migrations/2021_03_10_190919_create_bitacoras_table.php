<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacorasTable extends Migration
{
    public function up()
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->longText('suceso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bitacoras');
    }
}
