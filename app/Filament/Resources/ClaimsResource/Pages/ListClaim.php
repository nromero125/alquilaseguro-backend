<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClaim extends ListRecords
{
    protected static string $resource = ClaimResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans('messages.claim')]))
                ->icon('heroicon-o-plus'),
        ];
    }
}
