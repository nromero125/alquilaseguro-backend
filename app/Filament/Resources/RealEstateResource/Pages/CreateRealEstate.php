<?php

namespace App\Filament\Resources\RealEstateResource\Pages;

use App\Filament\Resources\RealEstateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRealEstate extends CreateRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.realEstate', 1)]);
    }
}
