<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Registration extends Model
{
    use SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'regi_no',
        'student_id',
        'class_id',
        'section_id',
        'academic_year_id',
        'roll_no',
        'shift',
        'card_no',
        'board_regi_no',
        'house',
        'status',
        'is_promoted',
        'old_registration_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function info()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function class()
    {
        return $this->belongsTo(IClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function acYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function attendance()
    {
        return $this->hasMany(StudentAttendance::class, 'registration_id');
    }

    public function attendanceSingleDay()
    {
        return $this->hasOne(StudentAttendance::class, 'registration_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'registration_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'registration_id');
    }

    public function scopeSection($query, $section)
    {
        if($section){
            return $query->where('section_id', $section);
        }

        return $query;
    }

    public function scopeCountOrGet($query, $isCount)
    {
        if($isCount){
            return $query->count();
        }

        return $query->get();
    }

    public function subjects()
    {
        return $this->belongsToMany(
            Subject::class,
            'student_subjects',
            'registration_id',
            'subject_id'
        )->withPivot('subject_type')->select('id','name','code','type');
    }
}
