<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\AppHelper;
use App\Models\Employee;
use App\Models\IClass;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => strtoupper(fake()->unique()->randomLetter),
            'capacity' => rand(20, 40),
            'class_id' => function () {
                return IClass::where('id', '!=', 1)->inRandomOrder()->first()->id;
            },
            'teacher_id' => function () {
                // Get random teacher id
                return Employee::where('role_id', AppHelper::USER_TEACHER)->inRandomOrder()->first()->id;
            },
            'note' => fake()->sentence,
            'status' => '1',
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'))
        ];
    }
}
