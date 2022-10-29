<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Owner;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
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

        Owner::factory()
            ->count(5)
            ->create([
                'bank_name' => $bank
            ]);
    }
}
