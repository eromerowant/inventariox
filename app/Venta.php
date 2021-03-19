<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
    
    public function status()
    {
        return $this->hasOne(PedidoStatus::class);
    }
}
