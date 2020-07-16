<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserRole;
use App\Http\Helpers\AppHelper;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo 'seeding users...', PHP_EOL;

        $superAdmin = User::create(
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@cloudschoolbd.com',
                'password' => bcrypt('super99'),
                'remember_token' => null,
                'is_super_admin' => true
            ]
        );

        $user = User::create(
            [
                'name' => 'Mr. admin',
                'username' => 'admin',
                'email' => 'admin@cloudschoolbd.com',
                'password' => bcrypt('demo123'),
                'remember_token' => null,
            ]
        );

       UserRole::create(
           [
               'user_id' => $superAdmin->id,
               'role_id' => AppHelper::USER_ADMIN
           ]
       );
        UserRole::create(
            [
                'user_id' => $user->id,
                'role_id' => AppHelper::USER_ADMIN
            ]
        );

    }
}
