<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Helpers\AppHelper;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $designation = [2,3,4,5,6,8,9,10,11,12,13,14,15,16,17,18,19,20];
        return [
            'user_id' => $user->id,
            'role_id' => AppHelper::USER_TEACHER,
            'id_card' => str_pad(fake()->unique()->numberBetween($min = 1, $max = 99),10,'0',STR_PAD_LEFT),
            'name' => fake()->name($gender = 'male'|'female'),
            'designation' => $designation[array_rand($designation, 1)],
            'qualification' => fake()->word,
            'dob' => fake()->dateTimeBetween($startDate = '-20 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
            'gender' => rand(1,2),
            'religion' => rand(1,5),
            'email'     => $user->email,
            'phone_no'  => fake()->e164PhoneNumber,
            'address' => fake()->address,
            'joining_date' => fake()->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = "Asia/Dhaka")->format('d/m/Y'),
            'photo'     => null,
            'signature' => null,
            'shift' => rand(1,2),
            'duty_start' => '09:00 am',
            'duty_end'  => '05:00 pm',
            'status' => '1',
            'created_by' => 1,
            'created_at' => Carbon::now(env('APP_TIMEZONE','Asia/Dhaka'))
        ];
    }
}
