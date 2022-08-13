<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hrshadhin\Userstamps\UserstampsTrait;

class UserRole extends Model
{
    use SoftDeletes, UserstampsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function role()
    {
        return $this->hasMany(Role::class);
    }
}
