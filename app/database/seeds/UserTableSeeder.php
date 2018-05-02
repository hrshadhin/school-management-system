<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();        
        User::create(array('firstname'=>'Mr.','lastname'=>'Admin','login'=>'admin','email' => 'admin@school.dev','group'=>'Admin','desc'=>'Admin Details Here',"password"=> Hash::make("demo123")));
        User::create(array('firstname'=>'Mr.','lastname'=>'Other','login'=>'other','email' => 'other@school.dev','group'=>'Other','desc'=>'other Deatils Here',"password"=> Hash::make("demo123")));
    }

}
