<?php

namespace App\Filament\Resources\RealEstateResource\Pages;

use App\Filament\Resources\RealEstateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRealEstate extends CreateRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.realEstate', 1)]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = empty($data['status']) ? false : $data['status'];
        return $data;
    }
}
