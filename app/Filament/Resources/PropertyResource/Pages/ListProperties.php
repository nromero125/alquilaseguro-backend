<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProperties extends ListRecords
{
    protected static string $resource = PropertyResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.property', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }
}
