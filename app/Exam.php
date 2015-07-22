<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date'];

    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    public function results()
    {
        return $this->hasMany('Zento\ExamResult');
    }

    public function addressStr()
    {
        return
            $this->location->street.' '.$this->location->housenr.'<br>'.
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }
}
