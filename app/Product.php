<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function purchase()
    {
        return $this->belongsTo('App\Purchase', 'purchase_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Sale', 'sale_id');
    }

    public function attributes()
    {
        return $this->hasMany('App\Attribute', 'product_id');
    }
}
