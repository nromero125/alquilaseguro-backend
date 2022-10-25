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
        User::factory()->admin()->create(['email' => 'admin@alquilaseguro.com']);
        User::factory()->insurer()->create(['email' => 'insurer@alquilaseguro.com']);
        User::factory()->owner()->create(['email' => 'owner@alquilaseguro.com']);
        User::factory()->tenant()->create(['email' => 'tenant@alquilaseguro.com']);
        User::factory()->broker()->create(['email' => 'broker@alquilaseguro.com']);
        User::factory()->brokerAdmin()->create(['email' => 'broker_admin@alquilaseguro.com']);
        User::factory()->insuranceAdmin()->create(['email' => 'insurance_admin@alquilaseguro.com']);
    }
}
