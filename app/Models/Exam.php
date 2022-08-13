<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hrshadhin\Userstamps\UserstampsTrait;

class Exam extends Model
{
    use HasFactory, SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'name',
        'elective_subject_point_addition',
        'marks_distribution_types',
        'status',
        'open_for_marks_entry'
    ];


    public function class()
    {
        return $this->belongsTo(IClass::class, 'class_id');
    }

    public function scopeIclass($query, $classId)
    {
        if($classId){
            return $query->where('class_id', $classId);
        }

        return $query;
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'exam_id');

    }

    public function result()
    {
        return $this->hasMany(Result::class, 'exam_id');

    }
}
