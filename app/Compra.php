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
        return $this->hasMany(CompraProducto::class);
    }
}
