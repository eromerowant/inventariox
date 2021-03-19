<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraProducto extends Model
{
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
