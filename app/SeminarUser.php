<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class SeminarUser extends Model
{
    public function seminar()
    {
        return $this->belongsTo('Zento\Seminar');
    }

    public function user()
    {
        return $this->hasMany('Zento\User');
    }
}
