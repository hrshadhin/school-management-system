<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'group',
    ];


    public function roles() {
        return $this->belongsToMany(Role::class,'roles_permissions')->whereNull('roles_permissions.deleted_at')->withTimestamps();
    }
}
