<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function ejemplar()
    {
        return $this->belongsTo(Ejemplare::class);
    }

    public function compra()
    {
        return $this->hasOne(CompraProducto::class);
    }

    public function pedido()
    {
        return $this->hasOne(ProductoPedido::class);
    }
}
