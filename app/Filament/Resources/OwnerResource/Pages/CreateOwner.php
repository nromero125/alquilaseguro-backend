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

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans('messages.owner')]);
    }

    protected function handleRecordCreation(array $data): Owner
    {
        $status = empty($data['status']) ? false : $data['status'];

        $user = User::query()->create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => UserTypes::OWNER,
            'status' => $status,
        ]);

        return Owner::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'identification_type' => $data['identification_type'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $status,
        ]);
    }
}
