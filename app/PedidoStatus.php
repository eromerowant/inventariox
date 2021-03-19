<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoStatus extends Model
{
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
