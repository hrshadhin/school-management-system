<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;

class Leave extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'leave_type',
        'leave_date',
        'document',
        'description',
        'status',
    ];

    protected $dates = ['leave_date'];


    public function getLeaveTypeAttribute($value)
    {
        return Arr::get(AppHelper::LEAVE_TYPES, $value);
    }

    public function setLeaveDateAttribute($value)
    {
        $this->attributes['leave_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function scopeWhereEmployee($query, $employee)
    {
        if($employee){
            return $query->where('employee_id', $employee);
        }

        return $query;
    }

    public function scopeWhereLeaveType($query, $leave_type)
    {
        if($leave_type){
            return $query->where('leave_type', $leave_type);
        }

        return $query;
    }

    public function scopeWhereLeaveDate($query, $leave_date)
    {
        if(strlen($leave_date)){
            return $query->whereDate('leave_date', Carbon::createFromFormat('d/m/Y', $leave_date)->format('Y-m-d'));
        }

        return $query;
    }

    public function scopeWhereStatus($query, $status)
    {
        if($status){
            return $query->where('status', $status);
        }

        return $query;
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id')->withTrashed();
    }
}
