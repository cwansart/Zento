<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
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
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Location relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    /**
     * Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('Zento\User');
    }


    /**
     * Returns a formatted string with the address. (Made for the views.)
     *
     * @return string
     */
    public function addressStr()
    {
        return
            ($this->location->street ? $this->location->street.' '.$this->location->housenr.'<br>' : '').
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }

    /**
     * Get mutator for street, so we can set validation rules for street without editing the requests.
     *
     * @param $null
     * @return mixed
     */
    public function getDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('d.m.Y');
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function setDateAttribute($date)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $date);
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function getStreetAttribute($null)
    {
        return $this->location->street;
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function getHousenrAttribute($null)
    {
        return $this->location->housenr;
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function getZipAttribute($null)
    {
        return $this->location->zip;
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function getCityAttribute($null)
    {
        return $this->location->city;
    }

    /**
     * See getDateAttribute.
     *
     * @param $date
     */
    public function getCountryAttribute($null)
    {
        return $this->location->country;
    }

    public function scopeGetOrdered($query, $orderBy) {
        $_orderBy = $order = null;
        if(!empty($orderBy) && strpos($orderBy, ':') !== false) {
            list($_orderBy, $order) = explode(':', $orderBy);
        }

        switch($_orderBy) {
            case 'date':
            case 'title':
                break;
            default:
                $_orderBy = 'date';
                break;
        }

        $order = $order == 'ASC' ? $order : 'DESC';
        return $query->orderBy($_orderBy, $order);
    }
}
