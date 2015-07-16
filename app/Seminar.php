<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    public function location()
    {
        return $this->hasOne('Zento\Location');
    }

    public function  users()
    {
        return $this->belongsToMany('Zento\User');
    }

}
