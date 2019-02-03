<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;

class StudentAttendance extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registration_id',
        'attendance_date',
        'present'
    ];




    public function student()
    {
        return $this->belongsTo('App\Registration', 'registration_id');
    }

    public function setAttendanceDateAttribute($value)
    {
        $this->attributes['attendance_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getAttendanceDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');

    }

    public function getPresentAttribute($value)
    {
        return Arr::get(AppHelper::ATTENDANCE_TYPE, $value);
    }
}
