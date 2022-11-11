<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.property', 1)]);
    }
}
