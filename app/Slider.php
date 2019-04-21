<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;


class Slider extends Model
{
    use SoftDeletes;
    use UserstampsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'subtitle', 'image', 'order',
    ];

}
