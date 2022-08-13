<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'password' => bcrypt('demo123'),
            'status' => '1',
            'force_logout' => 0,
            'remember_token' => Str::random(10),
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'))
        ];
    }
}
