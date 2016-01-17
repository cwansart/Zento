<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'location_id'
    ];

    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * Karate exam results.
     *
     * @var array
     */
    static public $results = [
        '9. Kyu', '8. Kyu', '7. Kyu',
        '6. Kyu', '5. Kyu', '4. Kyu',
        '3. Kyu', '2. Kyu', '1. Kyu',
        '1. Dan', '2. Dan', '3. Dan',
        '4. Dan', '5. Dan', '6. Dan',
        '7. Dan', '8. Dan', '9. Dan',
        '10. Dan'
    ];

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
     * Users relationship which also includes the exam result from the pivot table.
     *
     * @return $this
     */
    public function users()
    {
        return $this->belongsToMany('Zento\User')->withPivot('result');
    }

    /**
     * Returns a formatted string with the address. (Made for the views.)
     *
     * @return string
     */
    public function addressStr()
    {
        return
            $this->location->street.' '.$this->location->housenr.'<br>'.
            $this->location->zip.' '.$this->location->city.'<br>'.
            $this->location->country;
    }

    /**
     * Get date mutator to format the Carbon format to German format.
     *
     * @param $date
     * @return string
     */
    public function getDateAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('d.m.Y');
    }

    /**
     * Set mutator that re-formats the given German date to a Carbon date.
     *
     * @param $date
     */
    public function setDateAttribute($date)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $date);
    }

    /**
     * Get mutator for street, so we can set validation rules for street without editing the requests.
     *
     * @param $null
     * @return mixed
     */
    public function getStreetAttribute($null)
    {
        return $this->location->street;
    }

    /**
     * See getStreetAttribute.
     *
     * @param $null
     * @return mixed
     */
    public function getHousenrAttribute($null)
    {
        return $this->location->housenr;
    }

    /**
     * See getStreetAttribute.
     *
     * @param $null
     * @return mixed
     */
    public function getZipAttribute($null)
    {
        return $this->location->zip;
    }

    /**
     * See getStreetAttribute.
     *
     * @param $null
     * @return mixed
     */
    public function getCityAttribute($null)
    {
        return $this->location->city;
    }

    /**
     * See getStreetAttribute.
     *
     * @param $null
     * @return mixed
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
                break;
            default:
                $_orderBy = 'date';
                break;
        }

        $order = $order == 'ASC' ? $order : 'DESC';
        return $query->orderBy($_orderBy, $order);
    }
}
