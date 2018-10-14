<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'slug',
        'name',
    ];


    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
