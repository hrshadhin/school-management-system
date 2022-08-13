<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Section extends Model
{
    use HasFactory, SoftDeletes, UserstampsTrait;


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
        return $this->belongsTo(Employee::class, 'teacher_id');
    }
    public function class()
    {
        return $this->belongsTo(IClass::class, 'class_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'section_id');
    }

    public function student()
    {
        return $this->hasMany(Registration::class, 'section_id');
    }
}
