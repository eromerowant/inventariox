<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'entity_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_entities', 'entity_id', 'attribute_id');
    }
}
