<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagene extends Model
{
    public function ejemplar()
    {
        return $this->belongsTo(Ejemplare::class);
    }
}
