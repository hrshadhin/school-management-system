<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    $user = factory(App\User::class)->create();
    $designation = [2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20];
    return [
        'user_id' => $user->id,
        'role_id' => \App\Http\Helpers\AppHelper::USER_TEACHER,
        'id_card' => str_pad($faker->unique()->numberBetween($min = 1, $max = 99),10,'0',STR_PAD_LEFT),
        'name' => $faker->name($gender = 'male'|'female'),
        'designation' => $designation[array_rand($designation, 1)],
        'qualification' => $faker->word,
        'dob' => $faker->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
        'gender' => rand(1,2),
        'religion' => rand(1,5),
        'email'     => $user->email,
        'phone_no'  => $faker->e164PhoneNumber,
        'address' => $faker->address,
        'joining_date' => $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
        'photo'     => null,
        'signature' => null,
        'shift' => rand(1,2),
        'duty_start' => '09:00 am',
        'duty_end'  => '05:00 pm',
        'status' => '1'
    ];
});

