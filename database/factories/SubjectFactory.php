<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\IClass;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence($nbWords = 3, $variableNbWords = true),
            'code' => fake()->unique()->numberBetween($min = 100, $max = 200),
            'type' => rand(1, 2),
            'class_id' => function () {
                // Get random class id
                return IClass::where('id', '!=', 1)->where('id', '!=', 2)->inRandomOrder()->first()->id;
            },
            'status' => '1',
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'))
        ];
    }
}
