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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'location_id'
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
