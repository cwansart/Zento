<?php

namespace Zento;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

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
        'is_admin',
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
        'email' => 'required|email|unique:users',
        'password' => 'min:4',
        'birthday' => 'date|required',
        'entry_date' => 'date|required',
        'is_admin' => 'boolean',
        'active' => 'boolean'
    ];

    static public $editProfileRules = [
        'password' => 'min:4',
        'password2' => 'min:4',
        'email' => 'email|unique:users',
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

    public function getBirthdayAttribute($birthday)
    {
        return \Carbon\Carbon::parse($birthday)->format('d.m.Y');
    }

    public function getEntryDateAttribute($entryDate)
    {
        return \Carbon\Carbon::parse($entryDate)->format('d.m.Y');
    }
}
