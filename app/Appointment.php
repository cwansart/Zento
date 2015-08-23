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
        'user_id',
    ];

    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['date', 'end_date'];

    public function trainer()
    {
        return $this->belongsTo('Zento\User', 'user_id');
    }
}
