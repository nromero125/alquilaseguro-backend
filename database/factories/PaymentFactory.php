<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => fake()->numberBetween(30000, 100000),
            'payment_type' => fake()->numberBetween(1, 3),
            'property_id' => 1,
            'paid_at' => fake()->dateTimeThisYear,
            'is_late' => fake()->boolean(),
            'status' => fake()->numberBetween(1, 3),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
