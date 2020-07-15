<?php

use Faker\Generator as Faker;

$factory->define(App\Subject::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'code' => $faker->unique()->numberBetween($min = 100, $max = 200),
        'type' => rand(1,2),
        'class_id' => function () {
            // Get random class id
            return App\IClass::where('id','!=',1)->where('id','!=',2)->inRandomOrder()->first()->id;
        },
        'status' => '1',
    ];
});
