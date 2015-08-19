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

    public function getStreetAttribute($null)
    {
        return $this->location->street;
    }

    public function getHousenrAttribute($null)
    {
        return $this->location->housenr;
    }

    public function getZipAttribute($null)
    {
        return $this->location->zip;
    }

    public function getCityAttribute($null)
    {
        return $this->location->city;
    }

    public function getCountryAttribute($null)
    {
        return $this->location->country;
    }
}
