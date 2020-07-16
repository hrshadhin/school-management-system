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

    protected $dates = ['joining_date','leave_date'];


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
        'leave_date',
        'photo',
        'signature',
        'shift',
        'duty_start',
        'duty_end',
        'status',
        'order'
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

    public function getDesignationAttribute($value)
    {
        return Arr::get(AppHelper::EMPLOYEE_DESIGNATION_TYPES, $value);
    }


    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');

    }

    public function setLeaveDateAttribute($value)
    {
        if(strlen($value)) {
            $this->attributes['leave_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
        else{
            $this->attributes['leave_date'] = null;
        }

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


    public function attendance()
    {

        return $this->hasMany('App\EmployeeAttendance', 'employee_id');
    }


}
