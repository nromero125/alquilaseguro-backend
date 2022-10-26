<?php

namespace Database\Seeders;

use App\Models\Owner;
use App\Models\Payment;
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
    public function run()
    {
        $tenant = Tenant::factory()->create(['firstname' => 'Inquilino1', 'user_id' => 4]);
        $owner = Owner::factory()->create(['firstname' => 'Owner 1', 'user_id' => 3]);
        $property = Property::factory()->create(['name' => 'Propiedad 1', 'tenant_id' => $tenant->id, 'owner_id' => $owner->id]);
        Payment::factory()->count(10)->create(['property_id' => $property->id, 'tenant_id' => $tenant->id]);
    }
}
