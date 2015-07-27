<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'date',
        'end_date'
    ];

    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date', 'end_date'];

    /**
     * Sets the validator rules.
     *
     * @var array
     */
    static public $rules = [
        'street' => 'required|min:2', // we can't use "alpha" here since some streets are abbreviated with a dot
        'housenr' => 'required|min:2|alphanum', // since we save it as a string for occasions like "12b" alphanum's fine
        'zip' => 'digits:5|required', // are there any zipcodes that have more than 5 digits?
        'city' => 'min:2|alpha|required',
        'date' => 'date|required',
        'end_date' => 'date',
    ];

    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    public function addressStr()
    {
        return
            $this->location->street.' '.$this->location->housenr.'<br>'.
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }
}
