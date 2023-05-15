<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInsurance extends CreateRecord
{
    protected static string $resource = InsuranceResource::class;

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans('messages.insurance')]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = true;
        return $data;
    }
}
