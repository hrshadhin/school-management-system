<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leave>
 */
class LeaveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => function () {
                // Get random teacher id
                return Employee::inRandomOrder()->first()->id;
            },
            'leave_type' => rand(1,2),
            'leave_date' => fake()->dateTimeThisMonth($max = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
            'document' => null,
            'description' => fake()->sentence,
            'status' => rand(1,3),
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'))
        ];
    }
}
