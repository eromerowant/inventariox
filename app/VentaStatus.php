<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VentaStatus extends Model
{
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
