<?php

namespace App\Filament\Resources\BrokerResource\Pages;

use App\Enums\IdentificationTypes;
use App\Enums\UserTypes;
use App\Filament\Resources\BrokerResource;
use App\Models\User;
use App\Util\Util;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class EditBroker extends EditRecord
{
    protected static string $resource = BrokerResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->label(trans('messages.delete', ['item' => 'Broker']))
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::find($data['user_id']);

        $data['email'] = $user->email;
        $data['is_admin'] = $user->user_type === UserTypes::BROKER_ADMIN;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
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

        $user = User::find($record->user_id);

        $userData = [
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'status' => $data['status'],
            'user_type' => $data['is_admin'] ? UserTypes::BROKER_ADMIN : UserTypes::BROKER,
        ];

        if (! empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        $user->update($userData);

        $record->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'real_estate_id' => $data['real_estate_id'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $data['status'],
            'identification_type' => $data['identification_type']
        ]);

        return $record;
    }
}
