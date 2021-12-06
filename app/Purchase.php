<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'updated_at'
    ];

    protected $casts = [
        'created_at'  => 'date:d-m-Y H:i',
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'purchase_id');
    }
}
