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

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class, "attribute_id");
    }
}
