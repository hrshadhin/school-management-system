<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {

    $user = factory(App\User::class)->create();
    return [
        'user_id' => $user->id,
        'name' => $faker->name($gender = 'male'|'female'),
        'dob' => $faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
        'gender' => rand(1,2),
        'religion' => rand(1,5),
        'blood_group' => rand(1,8),
        'nationality' => substr($faker->country, 0 , 48),
        'photo' => null,
        'email' => $user->email,
        'phone_no' => $faker->e164PhoneNumber,
        'extra_activity' => '',
        'note' => '',
        'father_name' => $faker->name($gender = 'male'),
        'father_phone_no' => $faker->e164PhoneNumber,
        'mother_name' => $faker->name($gender = 'female'),
        'mother_phone_no' => $faker->e164PhoneNumber,
        'guardian' => null,
        'guardian_phone_no' => null,
        'present_address' => $faker->address,
        'permanent_address' => $faker->address,
        'status' => '1',
    ];
});
