<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_products', 'attribute_id', 'product_id');
    }

    public function entities()
    {
        return $this->belongsToMany(Entity::class, 'attribute_entities', 'attribute_id', 'entity_id');
    }

    public function product_value()
    {
        return $this->hasOne('App\Models\ValueProduct', 'attribute_id');
    }

    public function values()
    {
        return $this->belongsToMany(Value::class, 'attribute_values', 'attribute_id', 'value_id');
    }
}
