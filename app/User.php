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

    /**
     * The attributes map a color to an exam result.
     *
     * @var array
     */
    static private $colorResult = [
        '9. Kyu' => ['White', 'Yellow'],
        '8. Kyu' => 'Yellow',
        '7. Kyu' => 'Orange',
        '6. Kyu' => 'Green',
        '5. Kyu' => 'Blue',
        '4. Kyu' => 'Purple',
        '3. Kyu' => 'Brown',
        '2. Kyu' => 'Brown',
        '1. Kyu' => 'Brown',
        '1. Dan' => 'Black',
        '2. Dan' => 'Black',
        '3. Dan' => 'Black',
        '4. Dan' => 'Black',
        '5. Dan' => 'Black',
        '6. Dan' => 'Black',
        '7. Dan' => 'Black',
        '8. Dan' => 'Black',
        '9. Dan' => 'Black',
        '10. Dan' => 'Black'
    ];

    /**
     * Address relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo('Zento\Location', 'location_id');
    }

    /**
     * Group relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Zento\Group');
    }

    /**
     * Exams relationship.
     *
     * @return $this
     */
    public function exams()
    {
        return $this->belongsToMany('Zento\Exam')->withPivot('result');
    }

    /**
     * Seminars relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function seminars()
    {
        return $this->belongsToMany('Zento\Seminar');
    }

    /**
     * Users relationship which also includes the exam result from the pivot table.
     *
     * @return $this
     */
    public function appointments()
    {
        return $this->belongsToMany('Zento\Appointment')->withPivot('priority');
    }

    /**
     * Returns a formatted address string.
     *
     * @return string
     */
    public function addressStr()
    {
        return ($this->address->street ? $this->address->street.' '.$this->address->housenr.'<br>' : '').
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
    }

    /**
     * Returns the latest result as color if exists, otherwise it'll return white.
     *
     * @return string
     */
    public function latestResultColor($result)
    {
        return $result == 'Noch kein Ergebnis' ? 'White' : User::$colorResult[$result];
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

    public function scopeGetOrdered($query, $orderBy) {
        $_orderBy = $order = null;
        if(!empty($orderBy) && strpos($orderBy, ':') !== false) {
            list($_orderBy, $order) = explode(':', $orderBy);
        }

        switch($_orderBy) {
            case 'id':
            case 'firstname':
            case 'lastname':
            case 'email':
            case 'birthday':
            case 'entry_date':
            case 'group_id':
                break;
            default:
                $_orderBy = 'firstname';
                break;
        }

        $order = $order == 'DESC' ? $order : 'ASC';
        return $query->orderBy($_orderBy, $order);
    }
}
