<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class WorkOutside extends Model
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
        'work_date',
        'document',
        'description',
    ];

    protected $dates = ['work_date'];




    public function setWorkDateAttribute($value)
    {
        $this->attributes['work_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function scopeWhereEmployee($query, $employee)
    {
        if($employee){
            return $query->where('employee_id', $employee);
        }

        return $query;
    }

    public function scopeWhereWorkDate($query, $work_date)
    {
        if(strlen($work_date)){
            return $query->whereDate('work_date', Carbon::createFromFormat('d/m/Y', $leave_date)->format('Y-m-d'));
        }

        return $query;
    }



    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }
}
