<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.property', 1)]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = empty($data['status']) ? false : $data['status'];
        return $data;
    }
}
