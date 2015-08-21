<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'end_date',
        'all_day',
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
        'title' => 'required|min:3',
        'date' => 'date|required',
        'end_date' => 'date|required',
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
