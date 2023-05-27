<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClaims extends ListRecords
{
    protected static string $resource = ClaimResource::class;

    protected function getHeading(): string
    {
        return trans('messages.claims');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.claim', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTitle(): string
    {
        return trans_choice('messages.claim', 2);
    }
}
