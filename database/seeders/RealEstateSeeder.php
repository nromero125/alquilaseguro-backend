<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\RealEstate;
use Illuminate\Database\Seeder;

class RealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $banks = Bank::query()
            ->pluck("name")
            ->random(1);

        $bank = $banks[0];

        RealEstate::factory()
            ->count(5)
            ->hasBrokers(2, [
                'bank_name' => $bank
            ])
            ->create([
                'bank_name' => $bank
            ]);
    }
}
