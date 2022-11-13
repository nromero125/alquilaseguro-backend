<?php

namespace App\Filament\Resources\InsurerResource\Pages;

use App\Filament\Resources\InsurerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsurers extends ListRecords
{
    protected static string $resource = InsurerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
