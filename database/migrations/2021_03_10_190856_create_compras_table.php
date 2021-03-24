<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            $table->integer('cantidad')->unsigned();
            $table->decimal('precio_total', 8, 2)->comment('xxXXXxxx.xx');
            $table->string('status')->comment('1 es en espera. 2 es recibida')->default(1);
            $table->string('enlace_url')->comment('enlace hacia el proveedor')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
}