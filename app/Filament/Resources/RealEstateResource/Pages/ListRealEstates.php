<?php

namespace App\Filament\Resources\RealEstateResource\Pages;

use App\Filament\Resources\RealEstateResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealEstates extends ListRecords
{
    protected static string $resource = RealEstateResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.realEstate', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTitle(): string
    {
        return trans_choice('messages.realEstate', 2);
    }
}
