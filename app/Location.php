<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    public function users()
    {
        return $this->hasMany('Zento\User');
    }
}
