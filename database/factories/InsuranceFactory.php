<?php

namespace Database\Factories;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Insurance>
 */
class InsuranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'status' => true,
            'contact_person' => fake()->name(),
            'email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'rnc' => fake()->e164PhoneNumber(),
        ];
    }
}
