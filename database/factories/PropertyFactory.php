<?php

namespace Database\Factories;

use App\Models\Broker;
use App\Models\Owner;
use App\Models\Property;
use App\Models\RealEstate;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owner_id' => Owner::factory(),
            'broker_id' => Broker::factory(),
            'tenant_id' => Tenant::factory(),
            'real_estate_id' => RealEstate::factory(),
            'payment_due_date' => fake()->dateTimeThisYear,
            'description' => fake()->sentence(),
            'code' => fake()->randomDigitNotNull,
            'address' => fake()->address(),
            'status' => fake()->numberBetween(1, 3),
            'monthly_payment' => fake()->numberBetween(30000, 100000),
            'name' => fake()->company()
        ];
    }
}
