<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class IClass extends Model
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
        return $this->hasMany('App\Section', 'class_id');
    }

    public function student()
    {
        return $this->hasMany('App\Registration', 'class_id');
    }

    public function attendance()
    {
        return $this->hasMany('App\StudentAttendance', 'class_id');
    }
}
