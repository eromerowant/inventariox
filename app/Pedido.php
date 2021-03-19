<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function productos()
    {
        return $this->hasMany(ProductoPedido::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->hasOne(PedidoStatus::class);
    }
}
