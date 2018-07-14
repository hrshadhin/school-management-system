<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class ClassProfile extends Model
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
        'slug',
        'image_sm',
        'image_lg',
        'teacher',
        'room_no',
        'capacity',
        'shift',
        'short_description',
        'description',
        'outline',
    ];
}
