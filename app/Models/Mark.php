<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Mark extends Model
{
    use SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'academic_year_id',
        'class_id',
        'section_id',
        'registration_id',
        'exam_id',
        'subject_id',
        'marks',
        'total_marks',
        'grade',
        'point',
        'present',
    ];



    public function student()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function class()
    {
        return $this->belongsTo(IClass::class, 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
