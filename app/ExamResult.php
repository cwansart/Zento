<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
}
