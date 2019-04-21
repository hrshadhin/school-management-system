<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;

class Employee extends Model
{
    use SoftDeletes;
    use UserstampsTrait;

    protected $dates = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id',
        'id_card',
        'name',
        'designation',
        'qualification',
        'dob',
        'gender',
        'religion',
        'email',
        'phone_no',
        'address',
        'joining_date',
        'photo',
        'signature',
        'shift',
        'duty_start',
        'duty_end',
        'status'
    ];


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }


    public function getGenderAttribute($value)
    {
        return Arr::get(AppHelper::GENDER, $value);
    }

    public function getShiftAttribute($value)
    {
        return Arr::get(AppHelper::EMP_SHIFTS, $value);
    }
    public function setDutyStartAttribute($value)
    {
        if(strlen($value)){
            $this->attributes['duty_start'] = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        }

    }

    public function getDutyStartAttribute($value)
    {
        if(!strlen($value)){
            return null;
        }

        return Carbon::parse($value);

    }

    public function setDutyEndAttribute($value)
    {
        if(strlen($value)){
            $this->attributes['duty_end'] = Carbon::createFromFormat('h:i a', $value)->format('H:i:s');
        }

    }

    public function getDutyEndAttribute($value)
    {
        if(!strlen($value)){
            return null;
        }
        return Carbon::parse($value);

    }


    public function getReligionAttribute($value)
    {
        return Arr::get(AppHelper::RELIGION, $value);
    }

    public function class()
    {
        return $this->hasMany('App\IClass', 'teacher_id');
    }

    public function section()
    {
        return $this->hasMany('App\Section', 'teacher_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id');
    }


}
