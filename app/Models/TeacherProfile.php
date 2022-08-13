<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class TeacherProfile extends Model
{

    use SoftDeletes, UserstampsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'description',
        'designation',
        'qualification',
        'facebook',
        'instagram',
        'twitter',
    ];
}
