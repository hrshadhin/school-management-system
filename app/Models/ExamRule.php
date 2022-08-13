<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class ExamRule extends Model
{
    use SoftDeletes, UserstampsTrait;


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
        return $this->belongsTo(IClass::class, 'class_id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function combineSubject()
    {
        return $this->belongsTo(Subject::class, 'combine_subject_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
