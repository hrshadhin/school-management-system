<?php
namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

    public function roles() {
        return $this->belongsToMany(Role::class,'user_roles')->whereNull('user_roles.deleted_at');

    }


    public function permissions() {
        return $this->belongsToMany(Permission::class,'users_permissions')->whereNull('users_permissions.deleted_at');

    }

    public function hasRole( ... $roles ) {
        foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionThroughRole($permission) {
        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermissionTo($permission) {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    protected function hasPermission($permission) {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    // I used soft delete so i have to do it manually for both add and delete permission
    // that's why i don't need below functions
//    public function givePermissionsTo(... $permissions) {
//        $permissions = $this->getAllPermissions($permissions);
//
//        if($permissions === null) {
//            return $this;
//        }
//        $this->permissions()->saveMany($permissions);
//        return $this;
//    }
//
//    public function deletePermissions( ... $permissions ) {
//        $permissions = $this->getAllPermissions($permissions);
//        $this->permissions()->detach($permissions);
//        return $this;
//    }
//
//    private function getAllPermissions($permissions)
//    {
//        return Permission::whereIn('name', $permissions)->get();
//    }
}