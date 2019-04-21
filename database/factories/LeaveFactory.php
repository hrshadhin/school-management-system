<?php

use Faker\Generator as Faker;

$factory->define(App\Leave::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            // Get random teacher id
            return App\Employee::inRandomOrder()->first()->id;
        },
        'leave_type' => rand(1,2),
        'leave_date' => $faker->dateTimeThisMonth($max = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
        'document' => null,
        'description' => $faker->sentence,
        'status' => rand(1,3)
    ];
});
