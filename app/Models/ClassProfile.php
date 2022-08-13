<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class ClassProfile extends Model
{
    use SoftDeletes, UserstampsTrait;

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
