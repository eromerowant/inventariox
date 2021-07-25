<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    public function status()
    {
        return $this->hasOne(CompraStatus::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function ejemplar()
    {
        return $this->belongsTo(Ejemplare::class);
    }
}
