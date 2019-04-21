<?php

use Faker\Generator as Faker;

$factory->define(App\WorkOutside::class, function (Faker $faker) {
    return [
        'employee_id' => function () {
            // Get random teacher id
            return App\Employee::inRandomOrder()->first()->id;
        },
        'work_date' => $faker->dateTimeThisMonth($max = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
        'document' => null,
        'description' => $faker->sentence,
    ];
});
