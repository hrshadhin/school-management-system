<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Result extends Model
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
        'registration_id',
        'exam_id',
        'total_marks',
        'grade',
        'point',
        'subject_fail_count',
    ];


    public function student()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
