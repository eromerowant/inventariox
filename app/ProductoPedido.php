<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoPedido extends Model
{
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
