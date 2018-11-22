<?php

namespace App;

use App\Http\Helpers\AppHelper;
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
        'emp_type',
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

    public function getEmpTypeAttribute($value)
    {
        return Arr::get(AppHelper::EMP_TYPES, $value);
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

}
