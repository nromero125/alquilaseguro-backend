<?php

namespace Database\Factories;

use App\Models\Broker;
use App\Models\RealEstate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Broker>
 */
class BrokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone_number' => fake()->phoneNumber(),
            'identification' => fake()->creditCardNumber(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'address' => fake()->address(),
            'bank_name' => fake()->companySuffix(),
            'bank_account' => fake()->phoneNumber(),
            'real_estate_id' => RealEstate::factory()
        ];
    }
}
