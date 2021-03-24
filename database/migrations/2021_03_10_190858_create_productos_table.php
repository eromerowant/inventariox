<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ejemplar_id');
            $table->foreign('ejemplar_id')->references('id')->on('ejemplares');

            $table->unsignedBigInteger('compra_id');
            $table->foreign('compra_id')->references('id')->on('compras');

            $table->decimal('costo_unitario', 12, 2)->comment('xxxxxxxx.xx');
            $table->decimal('precio_sugerido', 12, 2)->comment('xxxxxxxx.xx');
            $table->tinyInteger('status')->default(1)->comment('1 es en espera y 2 es disponible');
            $table->text('qr_code')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
