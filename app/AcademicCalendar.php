<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcademicCalendar extends Model
{
    protected  $dates = ['date_from', 'date_upto'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','date_from', 'date_upto', 'is_holiday','is_exam','class_ids','description'];
}
