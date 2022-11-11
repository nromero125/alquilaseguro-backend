<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Enums\UserTypes;
use App\Filament\Resources\OwnerResource;
use App\Models\Owner;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.owner', 1)]);
    }

    protected function handleRecordCreation(array $data): Owner
    {
        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => UserTypes::OWNER,
            'status' => $data['status'],
        ]);

        return Owner::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $data['status'],
        ]);
    }
}
