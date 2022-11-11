<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInsurance extends CreateRecord
{
    protected static string $resource = InsuranceResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.insurance', 1)]);
    }
}
