<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOwners extends ListRecords
{
    protected static string $resource = OwnerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans('messages.owner')]))
                ->icon('heroicon-o-plus'),
        ];
    }
}
