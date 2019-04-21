<?php

use Faker\Generator as Faker;

$factory->define(App\Section::class, function (Faker $faker) {

    return [
        'name' => strtoupper($faker->unique()->randomLetter),
        'capacity' => rand(20,40),
        'class_id' => function(){
            return App\IClass::where('id','!=',1)->inRandomOrder()->first()->id;
        },
        'teacher_id' => function () {
            // Get random teacher id
            return App\Employee::where('role_id', \App\Http\Helpers\AppHelper::USER_TEACHER)->inRandomOrder()->first()->id;
        },
        'note' => $faker->sentence,
        'status' => '1',
    ];
});
