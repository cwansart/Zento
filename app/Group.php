<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
