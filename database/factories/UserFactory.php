<?php

namespace Database\Factories;

use App\Enums\UserTypes;
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
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'user_type' => fake()->numberBetween(1,5),
            'status' => 1
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
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
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::ADMIN,
            ];
        });
    }

    /**
     * Indicate that the model's role should be INSURER.
     *
     * @return static
     */
    public function insurer()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::INSURER,
            ];
        });
    }

    /**
     * Indicate that the model's role should be OWNER.
     *
     * @return static
     */
    public function owner()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::OWNER,
            ];
        });
    }

    /**
     * Indicate that the model's role should be TENANT.
     *
     * @return static
     */
    public function tenant()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::TENANT,
            ];
        });
    }

    /**
     * Indicate that the model's role should be BROKER.
     *
     * @return static
     */
    public function broker()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::BROKER,
            ];
        });
    }

     /**
     * Indicate that the model's role should be BROKER_ADMIN.
     *
     * @return static
     */
    public function brokerAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::BROKER_ADMIN,
            ];
        });
    }

    /**
     * Indicate that the model's role should be INSURANCE_ADMIN.
     *
     * @return static
     */
    public function insuranceAdmin()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_type' => UserTypes::INSURANCE_ADMIN,
            ];
        });
    }
}
