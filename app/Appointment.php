<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'title',
        'description',
        'start',
        'end',
        'allDay',
        'user_id',
    ];

    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['start', 'end'];

    /**
     * The attributes map a integer to a priority
     *
     * @var array
     */
    static public $priority = [
        0 => 'Nicht möglich',
        1 => 'Niedrig',
        2 => 'Normal',
        3 => 'Hoch'
    ];

    /**
     * Users relationship which also includes the exam result from the pivot table.
     *
     * @return $this
     */
    public function trainer()
    {
        return $this->belongsToMany('Zento\User')->withPivot('priority', 'reminder');
    }

    public function getStartAttribute($date)
    {
        $format = $this->allDay ? 'd.m.Y' : 'd.m.Y H:i';
        return \Carbon\Carbon::parse($date)->format($format);
    }

    public function getEndAttribute($date)
    {
        $format = $this->allDay ? 'd.m.Y' : 'd.m.Y H:i';
        return \Carbon\Carbon::parse($date)->format($format);
    }


    public function setUserIdAttribute($userId)
    {
        $this->attributes['user_id'] = $userId > 0 ? $userId : null;
    }

    public static $weekdays = [
        'Montag',
        'Dienstag',
        'Mittwoch',
        'Donnerstag',
        'Freitag',
        'Samstag',
        'Sonntag'
    ];


    public static $months = [
        'Januar',
        'Februar',
        'März',
        'April',
        'Mai',
        'Juni',
        'Juli',
        'August',
        'September',
        'Oktober',
        'November',
        'Dezember'
    ];
}
