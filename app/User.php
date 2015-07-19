<?php

namespace Zento;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'email', 'password', 'birthday', 'entry_date', 'location_id', 'active', 'group_id', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function address()
    {
        return $this->belongsTo('Zento\Location', 'location_id');
    }

    public function group()
    {
        return $this->belongsTo('Zento\Group');
    }

    public function results()
    {
        return $this->hasMany('Zento\ExamResult');
    }

    public function seminars()
    {
        return $this->belongsToMany('Zento\Seminar');
    }
}
