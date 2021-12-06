<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Value extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'value_products', 'value_id', 'product_id');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Attribute', 'attribute_id');
    }
}
