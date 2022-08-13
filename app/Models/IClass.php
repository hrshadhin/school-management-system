<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class IClass extends Model
{
    use SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'numeric_value',
        'order',
        'group',
        'duration',
        'have_selective_subject',
        'max_selective_subject',
        'have_elective_subject',
        'is_open_for_admission',
        'status',
        'note'
    ];


    public function section()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function student()
    {
        return $this->hasMany(Registration::class, 'class_id');
    }

    public function attendance()
    {
        return $this->hasMany(StudentAttendance::class, 'class_id');
    }
}
