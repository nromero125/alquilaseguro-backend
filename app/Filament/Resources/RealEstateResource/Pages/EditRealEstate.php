<?php

namespace App\Filament\Resources\RealEstateResource\Pages;

use App\Filament\Resources\RealEstateResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealEstate extends EditRecord
{
    protected static string $resource = RealEstateResource::class;

    protected function getHeading(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.realEstate', 1)]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->label(trans('messages.delete', ['item' => trans_choice('messages.realEstate', 1)]))
                ->icon('heroicon-o-trash'),
        ];
    }
}
