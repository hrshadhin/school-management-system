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
        'teacher_id',
        'name',
        'numeric_value',
        'status'
    ];


    public function teacher()
    {
        return $this->hasOne('App\Employee', 'teacher_id');
    }

    public function section()
    {
        return $this->hasMany('App\Section', 'class_id');
    }
}
