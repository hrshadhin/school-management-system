<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Section extends Model
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
        'capacity',
        'class_id',
        'teacher_id',
        'note',
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
        return $this->hasMany('App\Mark', 'section_id');
    }

    public function student()
    {
        return $this->hasMany('App\Registration', 'section_id');
    }
}
