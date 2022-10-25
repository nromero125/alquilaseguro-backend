<?php

namespace Database\Factories;

use App\Enums\UserTypes;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
            'user_type' => fake()->numberBetween(1, 5),
            'status' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's role should be ADMIN.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::ADMIN]);
    }

    /**
     * Indicate that the model's role should be INSURER.
     *
     * @return static
     */
    public function insurer(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::INSURER]);
    }

    /**
     * Indicate that the model's role should be OWNER.
     *
     * @return static
     */
    public function owner(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::OWNER]);
    }

    /**
     * Indicate that the model's role should be TENANT.
     *
     * @return static
     */
    public function tenant(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::TENANT]);
    }

    /**
     * Indicate that the model's role should be BROKER.
     *
     * @return static
     */
    public function broker(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::BROKER]);
    }

    /**
     * Indicate that the model's role should be BROKER_ADMIN.
     *
     * @return static
     */
    public function brokerAdmin(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::BROKER_ADMIN]);
    }

    /**
     * Indicate that the model's role should be INSURANCE_ADMIN.
     *
     * @return static
     */
    public function insuranceAdmin(): static
    {
        return $this->state(fn () => ['user_type' => UserTypes::INSURANCE_ADMIN]);
    }
}
