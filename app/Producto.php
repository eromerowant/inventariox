<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function ejemplar()
    {
        return $this->belongsTo(Ejemplare::class, "ejemplar_id");
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function pedido()
    {
        return $this->hasOne(ProductoPedido::class);
    }
}
