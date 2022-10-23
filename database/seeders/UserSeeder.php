<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->admin()->create(['email' => 'admin@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->insurer()->create(['email' => 'insurer@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->owner()->create(['email' => 'owner@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->tenant()->create(['email' => 'tenant@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->broker()->create(['email' => 'broker@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->brokerAdmin()->create(['email' => 'broker_admin@alquilaseguro.com', 'password' => bcrypt('password')]);
        User::factory()->insuranceAdmin()->create(['email' => 'insurance_admin@alquilaseguro.com', 'password' => bcrypt('password')]);
    }
}
