<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Enums\UserTypes;
use App\Filament\Resources\TenantResource;
use App\Models\Tenant;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.tenant', 1)]);
    }

    protected function handleRecordCreation(array $data): Tenant
    {
        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => UserTypes::TENANT,
            'status' => $data['status'],
        ]);

        return Tenant::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $data['status'],
            'contract_start_date' => $data['contract_start_date'],
            'contract_end_date' => $data['contract_end_date']
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = empty($data['status']) ? false : $data['status'];
        return $data;
    }
}
