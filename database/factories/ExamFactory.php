<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\AppHelper;
use App\Models\IClass;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'elective_subject_point_addition' => rand(0,2),
            'marks_distribution_types' => json_encode(array_rand(AppHelper::MARKS_DISTRIBUTION_TYPES, 3)),
            'class_id' => function () {
                // Get random class id
                return IClass::where('id','!=',1)->inRandomOrder()->first()->id;
            },
            'status' => '1',
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'))
        ];
    }
}
