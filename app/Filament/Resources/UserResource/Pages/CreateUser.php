<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\UserTypes;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.user', 1)]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_type'] = UserTypes::ADMIN;

        return $data;
    }
}
