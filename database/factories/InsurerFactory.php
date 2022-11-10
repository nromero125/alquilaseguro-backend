<?php

namespace Database\Factories;

use App\Models\Insurance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insurer>
 */
class InsurerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'phone_number' => fake()->phoneNumber(),
            'identification' => fake()->creditCardNumber(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'address' => fake()->address(),
            'insurance_id' => Insurance::factory(),
        ];
    }
}
