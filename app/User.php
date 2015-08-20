<?php

namespace Zento;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Hash;

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

    /*
     * Relationships
     */
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

    /**
     * Returns a formatted address string.
     *
     * @return string
     */
    public function addressStr()
    {
        return //$this->firstname.' '.$this->lastname.'<br>'.
               $this->address->street.' '.$this->address->housenr.'<br>'.
               $this->address->zip.' '.$this->address->city.'<br>'.
               $this->address->country;
    }

    /**
     * Returns the latest result if exists, otherwise it'll return an information.
     *
     * @return string
     */
    public function latestResult()
    {
        $latestExam = $this->exams()->orderBy('date', 'desc')->first();
        return $latestExam == null ? 'Noch kein Ergebnis' : $latestExam->pivot->result;
        return $latestExam;
    }

    /*
     * Several mutators for simplify code in the controllers.
     */
    public function getBirthdayAttribute($birthday)
    {
        return \Carbon\Carbon::parse($birthday)->format('d.m.Y');
    }

    public function getEntryDateAttribute($entryDate)
    {
        return \Carbon\Carbon::parse($entryDate)->format('d.m.Y');
    }

    public function setBirthdayAttribute($birthday)
    {
        $this->attributes['birthday'] = \Carbon\Carbon::createFromFormat('d.m.Y', $birthday);
    }

    public function setEntryDateAttribute($entryDate)
    {
        $this->attributes['entry_date'] = \Carbon\Carbon::createFromFormat('d.m.Y', $entryDate);
    }

    public function setIsAdminAttribute($isAdmin)
    {
        $this->attributes['is_admin'] = empty($isAdmin) ? false : $isAdmin;
    }

    public function setActiveAttribute($active)
    {
        $this->attributes['active'] = empty($active) ? false : $active;
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = empty($password) ? false : Hash::make($password);
    }

    public function getStreetAttribute($null)
    {
        return $this->address->street;
    }

    public function getHousenrAttribute($null)
    {
        return $this->address->housenr;
    }

    public function getZipAttribute($null)
    {
        return $this->address->zip;
    }

    public function getCityAttribute($null)
    {
        return $this->address->city;
    }

    public function getCountryAttribute($null)
    {
        return $this->address->country;
    }
}
