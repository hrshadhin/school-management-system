<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Mr. admin',
                'username' => 'admin',
                'email' => 'admin@sms.com',
                'password' => bcrypt('demo123'),
                'remember_token' => null,
            ]
        );
    }
}
