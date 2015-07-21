<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    public function users()
    {
        return $this->belongsToMany('Zento\User');
    }

    public function addressStr()
    {
        return
            $this->location->street.' '.$this->location->housenr.'<br>'.
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }
}
