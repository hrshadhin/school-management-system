<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(
            [
                'name' => 'Admin',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Teacher',
                'deletable' => false,
            ]
        );

        Role::create(
            [
                'name' => 'Student',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Parents',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Accountant',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Librarian',
                'deletable' => false,
            ]
        );
        Role::create(
            [
                'name' => 'Receptionist',
                'deletable' => false,
            ]
        );


//        $dev_permission = Permission::where('slug','create-tasks')->first();
//        $manager_permission = Permission::where('slug', 'edit-users')->first();
//        $dev_role = new Role();
//        $dev_role->slug = 'developer';
//        $dev_role->name = 'Front-end Developer';
//        $dev_role->save();
//        $dev_role->permissions()->attach($dev_permission);
//
//        $manager_role = new Role();
//        $manager_role->slug = 'manager';
//        $manager_role->name = 'Assistant Manager';
//        $manager_role->save();
//        $manager_role->permissions()->attach($manager_permission);
    }

}
