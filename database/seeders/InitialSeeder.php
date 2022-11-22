<?php

namespace Database\Seeders;

use App\Enums\PaymentTypes;
use App\Models\Bank;
use App\Models\Broker;
use App\Models\Claim;
use App\Models\Insurance;
use App\Models\Insurer;
use App\Models\Owner;
use App\Models\Payment;
use App\Models\Policy;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $banks = Bank::query()
            ->pluck('name')
            ->random(1);

        $bank = $banks[0];

        $tenant = Tenant::factory()
            ->create([
                'firstname' => 'Inquilino1',
                'user_id' => 4,
            ]);

        $owner = Owner::factory()
            ->create([
                'firstname' => 'Owner 1',
                'user_id' => 3,
            ]);

        $broker = Broker::factory()
            ->create([
                'firstname' => 'Broker 1',
                'user_id' => 5,
                'bank_name' => $bank,
            ]);

        Insurance::factory()->create();

        $insurer = Insurer::factory()
            ->create([
                'firstname' => 'Insurer',
                'user_id' => 2,
                'insurance_id' => 1,
            ]);

        $brokerAdmin = Broker::factory()
            ->create([
                'firstname' => 'Broker Admin',
                'user_id' => 6,
                'bank_name' => $bank,
            ]);

        $InsurerAdmin = Insurer::factory()
            ->create([
                'firstname' => 'Insurance Admin',
                'user_id' => 7,
                'insurance_id' => 1,
            ]);

        $policy = Policy::create([
            'insurance_id' => 1,
            'name' => 'Seguro full',
            'description' => 'Poliza',
            'validity' => 24,
        ]);

        $property = Property::factory()
            ->create([
                'name' => 'Propiedad 1',
                'tenant_id' => $tenant->id,
                'owner_id' => $owner->id,
                'broker_id' => $broker->id,
                'policy_id' => $policy->id,
            ]);

        Claim::factory()
            ->count(10)
            ->create([
                'user_id' => $tenant->user_id,
                'property_id' => $property->id,
                'insurance_id' => 1,
            ]);

        Payment::factory()
            ->count(10)
            ->create([
                'property_id' => $property->id,
                'tenant_id' => $tenant->id,
            ]);

        Payment::factory()->count(5)->create([
            'insurance_id' => 1,
            'property_id' => null,
            'owner_id' => null,
            'broker_id' => null,
            'tenant_id' => null,
            'payment_type' => PaymentTypes::INSURANCE_PAYMENT,
        ]);

        Payment::factory()->count(5)->create([
            'owner_id' => $owner->id,
            'property_id' => null,
            'property_id' => null,
            'broker_id' => null,
            'tenant_id' => null,
            'payment_type' => PaymentTypes::OWNER_PAYMENT,
        ]);

        Payment::factory()->count(5)->create([
            'broker_id' => $broker->id,
            'property_id' => null,
            'property_id' => null,
            'owner_id' => null,
            'tenant_id' => null,
            'payment_type' => PaymentTypes::BROKER_PAYMENT,
        ]);
    }
}
