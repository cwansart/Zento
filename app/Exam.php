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

    /**
     * Sets the validator rules.
     *
     * @var array
     */
    static public $rules = [
        'street' => 'required|min:2|required', // we can't use "alpha" here since some streets are abbreviated with a dot
        'housenr' => 'required|min:2|alphanum|required', // since we save it as a string for occasions like "12b" alphanum's fine
        'zip' => 'digits:5|required', // are there any zipcodes that have more than 5 digits?
        'city' => 'min:2|alpha|required',
        'date' => 'date|required',
    ];

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
