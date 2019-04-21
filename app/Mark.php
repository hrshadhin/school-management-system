<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Mark extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


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
        return $this->belongsTo('App\Registration', 'registration_id');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam', 'exam_id');
    }

    public function class()
    {
        return $this->belongsTo('App\IClass', 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
}
