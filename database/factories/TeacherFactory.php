<?php

use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'role_id' => \App\Http\Helpers\AppHelper::USER_TEACHER,
        'id_card' => str_pad(rand(1,99),10,'0',STR_PAD_LEFT),
        'name' => $faker->name,
        'designation' => $faker->jobTitle,
        'qualification' => $faker->spki,
        'dob',
        'gender',
        'religion',
        'email',
        'phone_no',
        'address',
        'joining_date',
        'photo',
        'signature',
        'shift',
        'duty_start',
        'duty_end',
        'status'
    ];
});

