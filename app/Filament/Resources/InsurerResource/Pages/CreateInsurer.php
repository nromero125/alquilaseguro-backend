<?php

namespace App\Filament\Resources\InsurerResource\Pages;

use App\Enums\UserTypes;
use App\Filament\Resources\InsurerResource;
use App\Models\Insurer;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateInsurer extends CreateRecord
{
    protected static string $resource = InsurerResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.insurer', 2)]);
    }

    protected function handleRecordCreation(array $data): Insurer
    {
        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => $data['is_admin'] ? UserTypes::INSURER_ADMIN : UserTypes::INSURER,
            'status' => $data['status'],
        ]);

        return Insurer::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'insurance_id' => $data['insurance_id'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $data['status'],
        ]);
    }
}
