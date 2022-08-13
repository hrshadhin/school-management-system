<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hrshadhin\Userstamps\UserstampsTrait;
use App\Http\Helpers\AppHelper;
use Illuminate\Support\Arr;


class Student extends Model
{
    use HasFactory, SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'nick_name',
        'dob',
        'gender',
        'religion',
        'blood_group',
        'nationality',
        'photo',
        'email',
        'phone_no',
        'extra_activity',
        'note',
        'father_name',
        'father_phone_no',
        'mother_name',
        'mother_phone_no',
        'guardian',
        'guardian_phone_no',
        'present_address',
        'permanent_address',
        'sms_receive_no',
        'siblings',
        'status',
    ];

    public function registration()
    {
        return $this->hasMany(Registration::class, 'student_id');
    }
    public function getGenderAttribute($value)
    {
        return Arr::get(AppHelper::GENDER, $value);
    }

    public function getReligionAttribute($value)
    {
        return Arr::get(AppHelper::RELIGION, $value);
    }

    public function getBloodGroupAttribute($value)
    {
        if($value) {
            return Arr::get(AppHelper::BLOOD_GROUP, $value);
        }
        return "";
    }
}
