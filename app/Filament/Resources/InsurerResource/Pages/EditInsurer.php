<?php

namespace App\Filament\Resources\InsurerResource\Pages;

use App\Enums\IdentificationTypes;
use App\Enums\UserTypes;
use App\Filament\Resources\InsurerResource;
use App\Models\User;
use App\Util\Util;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditInsurer extends EditRecord
{
    protected static string $resource = InsurerResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.insurer', 1)]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::query()->find($data['user_id']);

        $data['email'] = $user->email;
        $data['is_admin'] = $user->user_type === UserTypes::INSURER_ADMIN;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($data['identification_type'] === IdentificationTypes::DOMINICAN_ID->value && !Util::isValid($data['identification'])) {
            Notification::make()
                ->warning()
                ->title(trans('validation.identification', ['attribute' => trans('messages.identification')]))
                ->body(trans('validation.identification', ['attribute' => trans('messages.identification')]))
                ->persistent()
                ->send();

            $this->halt();
        }

        $user = User::query()->find($record->user_id);

        $userData = [
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'status' => $data['status'],
            'user_type' => $data['is_admin'] ? UserTypes::INSURER_ADMIN : UserTypes::INSURER,
        ];

        if (! empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        $user->update($userData);

        $record->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'insurance_id' => $data['insurance_id'],
            'phone_number' => $data['phone_number'],
            'identification_type' => $data['identification_type'],
            'identification' => $data['identification'],
            'status' => $data['status'],
        ]);

        return $record;
    }
}
