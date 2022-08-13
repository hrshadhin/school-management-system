<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'name' => fake()->name($gender = 'male'|'female'),
            'dob' => fake()->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
            'gender' => rand(1,2),
            'religion' => rand(1,5),
            'blood_group' => rand(1,8),
            'nationality' => substr(fake()->country, 0 , 48),
            'photo' => null,
            'email' => $user->email,
            'phone_no' => fake()->e164PhoneNumber,
            'extra_activity' => '',
            'note' => '',
            'father_name' => fake()->name($gender = 'male'),
            'father_phone_no' => fake()->e164PhoneNumber,
            'mother_name' => fake()->name($gender = 'female'),
            'mother_phone_no' => fake()->e164PhoneNumber,
            'guardian' => null,
            'guardian_phone_no' => null,
            'present_address' => fake()->address,
            'permanent_address' => fake()->address,
            'status' => '1',
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'))
        ];
    }
}
