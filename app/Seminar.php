<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'title',
        'location_id'
    ];

    /**
     * Sets the validator rules.
     *
     * @var array
     */
    static public $rules = [
        'street' => 'required|min:2', // we can't use "alpha" here since some streets are abbreviated with a dot
        'housenr' => 'required|min:1|alphanum', // since we save it as a string for occasions like "12b" alphanum's fine
        'zip' => 'digits:5|required', // are there any zipcodes that have more than 5 digits?
        'city' => 'min:2|required',
        'date' => 'date|required',
        'title' => 'required|min:3'
    ];

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
            ($this->location->street ? $this->location->street.' '.$this->location->housenr.'<br>' : '').
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }

    public function getDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('d.m.Y');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $date);
    }
}
