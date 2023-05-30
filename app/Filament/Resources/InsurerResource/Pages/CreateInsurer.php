<?php

namespace App\Filament\Resources\InsurerResource\Pages;

use App\Enums\IdentificationTypes;
use App\Enums\UserTypes;
use App\Filament\Resources\InsurerResource;
use App\Models\Insurer;
use App\Models\User;
use App\Util\Util;
use Filament\Notifications\Notification;
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
        if ($data['identification_type'] == IdentificationTypes::DOMINICAN_ID->value && !Util::isValid((int)$data['identification'])) {
            Notification::make()
                ->warning()
                ->title(trans('validation.identification', ['attribute' => trans('messages.identification')]))
                ->body(trans('validation.identification', ['attribute' => trans('messages.identification')]))
                ->persistent()
                ->send();

            $this->halt();
        }

        $status = empty($data['status']) ? false : $data['status'];

        $user = User::create([
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => $data['is_admin'] ? UserTypes::INSURER_ADMIN : UserTypes::INSURER,
            'status' => $status,
        ]);

        return Insurer::create([
            'user_id' => $user->id,
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'insurance_id' => $data['insurance_id'],
            'phone_number' => $data['phone_number'],
            'identification_type' => $data['identification_type'],
            'identification' => $data['identification'],
            'status' => $status,
        ]);
    }
}
