<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use App\Models\User;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditOwner extends EditRecord
{
    protected static string $resource = OwnerResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.owner', 1)]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::find($data['user_id']);

        $data['email'] = $user->email;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $user = User::find($record->user_id);

        $userData = [
            'name' => $data['firstname'].' '.$data['lastname'],
            'email' => $data['email'],
            'status' => $data['status'],
        ];

        if (! empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        $user->update($userData);

        $record->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone_number' => $data['phone_number'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'status' => $data['status'],
        ]);

        return $record;
    }
}
