<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompraStatus extends Model
{
    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}
