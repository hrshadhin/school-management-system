<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers\AppHelper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;
use Illuminate\Support\Arr;

class Template extends Model
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
        'type',
        'role_id',
        'content',
    ];



    public function getRoleIdAttribute($value)
    {
        return Arr::get(AppHelper::TEMPLATE_USERS, $value);
    }

    public function getTypeAttribute($value)
    {
        return Arr::get(AppHelper::TEMPLATE_TYPE, $value);
    }


}
