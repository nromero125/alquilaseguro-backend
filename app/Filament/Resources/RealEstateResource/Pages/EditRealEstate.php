<?php

namespace App\Filament\Resources\RealEstateResource\Pages;

use App\Filament\Resources\RealEstateResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealEstate extends EditRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.realEstate', 1)]);
    }
}
