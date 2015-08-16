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
        'street' => 'required|min:2', // we can't use "alpha" here since some streets are abbreviated with a dot
        'housenr' => 'required|min:2|alphanum', // since we save it as a string for occasions like "12b" alphanum's fine
        'zip' => 'digits:5|required', // are there any zipcodes that have more than 5 digits?
        'city' => 'min:2|alpha|required',
        'date' => 'date|required',
    ];

    static public $updateRules = [
        'userid' => 'required|numeric',
        'result' => 'required|numeric|between:0,17'
    ];

    static public $results = [
        '9. Kyu', '8. Kyu', '7. Kyu',
        '6. Kyu', '5. Kyu', '4. Kyu',
        '3. Kyu', '2. Kyu', '1. Kyu',
        '2. Dan', '3. Dan', '4. Dan',
        '5. Dan', '6. Dan', '7. Dan',
        '8. Dan', '9. Dan', '10. Dan',
    ];

    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    public function users()
    {
        return $this->belongsToMany('Zento\User')->withPivot('result');
    }

    public function addressStr()
    {
        return
            $this->location->street.' '.$this->location->housenr.'<br>'.
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }

    public function getDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('d.m.Y');
    }
}
