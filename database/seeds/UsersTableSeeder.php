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
        $user= User::create(
            [
                'name' => 'Mr. admin',
                'username' => 'admin',
                'email' => 'admin@sms.com',
                'password' => bcrypt('demo123'),
                'remember_token' => null,
            ]
        );

       UserRole::create(
           [
               'user_id' => $user->id,
               'role_id' => AppHelper::USER_ADMIN
           ]
       );

//        $dev_role = Role::where('slug','developer')->first();
//        $dev_perm = Permission::where('slug','create-tasks')->first();
//
//        $developer = new User();
//        $developer->name = 'Usama Muneer';
//        $developer->email = 'usama@thewebtier.com';
//        $developer->password = bcrypt('secret');
//        $developer->save();
//        $developer->roles()->attach($dev_role);
//        $developer->permissions()->attach($dev_perm);
    }
}
