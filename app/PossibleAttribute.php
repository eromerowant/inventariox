<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class PossibleAttribute extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function values()
    {
        return $this->hasMany('App\PossibleValue', 'possible_attribute_id');
    }

    public function entity()
    {
        return $this->belongsTo('App\PossibleEntity', 'possible_entity_id');
    }
}
