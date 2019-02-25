<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class ExamRule extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'subject_id',
        'exam_id',
        'grade_id',
        'combine_subject_id',
        'marks_distribution',
        'passing_rule',
        'total_exam_marks',
        'over_all_pass',
    ];

    public function class()
    {
        return $this->belongsTo('App\IClass', 'class_id');
    }
    public function exam()
    {
        return $this->belongsTo('App\Exam', 'exam_id');
    }

    public function combineSubject()
    {
        return $this->belongsTo('App\Subject', 'combine_subject_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'grade_id');
    }
}
