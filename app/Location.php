<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'zip',
        'city',
        'street',
        'housenr',
        'country',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->hasMany('Zento\User');
    }
}