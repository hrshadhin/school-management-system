<?php

use Faker\Generator as Faker;

$factory->define(App\Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'code' => $faker->unique()->numberBetween($min = 100, $max = 200),
        'type' => rand(1,2),
        'class_id' => function () {
            // Get random class id
            return App\IClass::where('id','!=',1)->inRandomOrder()->first()->id;
        },
        'teacher_id' => function () {
            // Get random teacher id
            return App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first()->id;
        },
        'status' => '1',
    ];
});
