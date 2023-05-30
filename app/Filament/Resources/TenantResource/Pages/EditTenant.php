<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Enums\IdentificationTypes;
use App\Filament\Resources\TenantResource;
use App\Models\User;
use App\Util\Util;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeading(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.tenant', 1)]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->label(trans('messages.delete', ['item' => trans_choice('messages.tenant', 1)]))
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::find($data['user_id']);

        $data['email'] = $user->email;

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
        ];

        if (! empty($data['password'])) {
            $userData['password'] = $data['password'];
        }

        $user->update($userData);

        $record->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone_number' => $data['phone_number'],
            'identification_type' => $data['identification_type'],
            'identification' => $data['identification'],
            'address' => $data['address'],
            'bank_name' => $data['bank_name'],
            'bank_account' => $data['bank_account'],
            'contract_start_date' => $data['contract_start_date'],
            'contract_end_date' => $data['contract_end_date'],
            'status' => $data['status'],
        ]);

        return $record;
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.tenant', 1)]);
    }
}
