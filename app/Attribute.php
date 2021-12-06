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

    public function entities()
    {
        return $this->belongsToMany(Entity::class, 'attribute_entities', 'attribute_id', 'entity_id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, "attribute_id");
    }
}
