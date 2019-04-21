<?php

namespace App;

use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;


class Subject extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'type',
        'class_id',
        'teacher_id',
        'status',
    ];


    public function teacher()
    {
        return $this->belongsTo('App\Employee', 'teacher_id');
    }
    public function class()
    {
        return $this->belongsTo('App\IClass', 'class_id');
    }

    public function marks()
    {
        return $this->hasMany('App\Mark', 'subject_id');
    }

    public function getTypeAttribute($value)
    {
        return Arr::get(AppHelper::SUBJECT_TYPE, $value);
    }

    public function scopeIclass($query, $classId)
    {
        if($classId){
            return $query->where('class_id', $classId);
        }

        return $query;
    }

    public function scopeSType($query, $subjectType)
    {
        if($subjectType){
            return $query->where('type', $subjectType);
        }

        return $query;
    }
}
