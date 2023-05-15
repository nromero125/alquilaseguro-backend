<?php

namespace App\Filament\Resources\BrokerResource\Pages;

use App\Enums\UserTypes;
use App\Filament\Resources\BrokerResource;
use App\Models\Broker;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateBroker extends CreateRecord
{
    protected static string $resource = BrokerResource::class;

    protected function handleRecordCreation(array $data): Broker
    {
        $status = empty($data['status']) ? true : $data['status'];

        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => $data['is_admin'] ? UserTypes::BROKER_ADMIN : UserTypes::BROKER,
            'status' => $status,
        ]);

        return Broker::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'real_estate_id' => $data['real_estate_id'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'identification_type' => $data['identification_type'],
            'status' => $status,
        ]);
    }
}
