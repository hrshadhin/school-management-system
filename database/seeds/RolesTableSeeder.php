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
        echo 'seeding roles...', PHP_EOL;

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


    }

}
