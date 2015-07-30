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
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'birthday',
        'entry_date',
        'location_id',
        'active',
        'group_id',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are stored as 'date' in the database.
     *
     * @var array
     */
    protected $dates = ['birthday', 'entry_date'];

    static public $rules = [
        'firstname' => 'required|min:2|alpha',
        'lastname' => 'required|min:2|alpha',
        'email' => 'required|email|unique',
        'password' => 'min:4',
        'birthday' => 'date|required',
        'entry_date' => 'date|required',
    ];

    public function address()
    {
        return $this->belongsTo('Zento\Location', 'location_id');
    }

    public function group()
    {
        return $this->belongsTo('Zento\Group');
    }

    public function exams()
    {
        return $this->belongsToMany('Zento\Exam')->withPivot('result');
    }

    public function seminars()
    {
        return $this->belongsToMany('Zento\Seminar');
    }

    public function addressStr()
    {
        return //$this->firstname.' '.$this->lastname.'<br>'.
               $this->address->street.' '.$this->address->housenr.'<br>'.
               $this->address->zip.' '.$this->address->city.'<br>'.
               $this->address->country;
    }
}
