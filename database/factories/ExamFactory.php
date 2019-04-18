<?php

use Faker\Generator as Faker;

$factory->define(App\Exam::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'elective_subject_point_addition' => rand(0,2),
        'marks_distribution_types' => json_encode(array_rand(\App\Http\Helpers\AppHelper::MARKS_DISTRIBUTION_TYPES, 3)),
        'class_id' => function () {
            // Get random class id
            return App\IClass::where('id','!=',1)->inRandomOrder()->first()->id;
        },
        'status' => '1',
    ];
});
