<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'phone_number' => fake()->phoneNumber(),
            'status' => fake()->numberBetween(1,3),
            'identification' => fake()->creditCardNumber(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'address' => fake()->address(),
            'bank_name' => fake()->companySuffix(),
            'bank_account' => fake()->phoneNumber(),
            'user_id' => User::factory(),
        ];

    }
}
