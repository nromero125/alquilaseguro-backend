<?php

namespace App\Filament\Resources\InsurerResource\Pages;

use App\Filament\Resources\InsurerResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInsurers extends ListRecords
{
    protected static string $resource = InsurerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.insurer', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTitle(): string
    {
        return trans_choice('messages.insurer', 2);
    }
}
