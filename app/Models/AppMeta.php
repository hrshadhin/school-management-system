<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppMeta extends Model
{
    use SoftDeletes, UserstampsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['meta_key','meta_value'];
}
