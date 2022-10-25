<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(InsuranceSeeder::class);
        $this->call(RealEstateSeeder::class);
        $this->call(OwnerSeeder::class);
        $this->call(PaymentSeeder::class);
        $this->call(PropertySeeder::class);
        $this->call(TenantSeeder::class);
    }
}
