<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('demo123'),
        'status' => '1',
        'force_logout' => 0,
        'remember_token' => Str::random(10),
        'created_by' => 1,
        'created_at' => now()
    ];
});
