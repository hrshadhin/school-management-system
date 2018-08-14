<?php

namespace App;

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
        'name',
        'designation',
        'dob',
        'gender',
        'religion',
        'email',
        'phone',
        'address',
        'joining_date',
        'photo',
        'status'
    ];


    public function user()
    {
        return $this->hasOne('App\User');
    }

    private $genders = [1 => 'Male', 2 => 'Female'];
    private $employee_type = [1 => 'Teacher', 2 => 'Stuff'];


    public function getGenderAttribute($value)
    {
        return Arr::get($this->genders, $value);
    }

    public function getEmpTypeAttribute($value)
    {
        return Arr::get($this->employee_type, $value);
    }



}
