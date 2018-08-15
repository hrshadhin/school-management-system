<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
//        User::truncate();
        Role::truncate();
//        UserRole::truncate();
        DB::statement("SET foreign_key_checks=1");
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
