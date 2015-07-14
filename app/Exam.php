<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function location()
    {
        return $this->belongsTo('Zento\Location');
    }

    public function results()
    {
        return $this->hasMany('Zento\ExamResult');
    }
}
