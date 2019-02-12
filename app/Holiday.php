<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class Holiday extends Model
{
    use SoftDeletes;
    use UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'holi_date',
        'description',
        'academic_year_id',
    ];

    protected $dates = ['holi_date'];


    public function setHoliDateAttribute($value)
    {
        $this->attributes['holi_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

}
